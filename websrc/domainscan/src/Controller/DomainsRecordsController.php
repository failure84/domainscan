<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DomainsRecords Controller
 *
 * @property \App\Model\Table\DomainsRecordsTable $DomainsRecords
 */
class DomainsRecordsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Domains', 'Vendors']
        ];
        $this->set('domainsRecords', $this->paginate($this->DomainsRecords));
        $this->set('_serialize', ['domainsRecords']);
    }

    /**
     * View method
     *
     * @param string|null $id Domains Record id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $domainsRecord = $this->DomainsRecords->get($id, [
            'contain' => ['Domains', 'Vendors']
        ]);
        $this->set('domainsRecord', $domainsRecord);
        $this->set('_serialize', ['domainsRecord']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $domainsRecord = $this->DomainsRecords->newEntity();
        if ($this->request->is('post')) {
            $domainsRecord = $this->DomainsRecords->patchEntity($domainsRecord, $this->request->data);
            if ($this->DomainsRecords->save($domainsRecord)) {
                $this->Flash->success(__('The domains record has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The domains record could not be saved. Please, try again.'));
            }
        }
        $domains = $this->DomainsRecords->Domains->find('list', ['limit' => 200]);
        $vendors = $this->DomainsRecords->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('domainsRecord', 'domains', 'vendors'));
        $this->set('_serialize', ['domainsRecord']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Domains Record id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $domainsRecord = $this->DomainsRecords->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $domainsRecord = $this->DomainsRecords->patchEntity($domainsRecord, $this->request->data);
            if ($this->DomainsRecords->save($domainsRecord)) {
                $this->Flash->success(__('The domains record has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The domains record could not be saved. Please, try again.'));
            }
        }
        $domains = $this->DomainsRecords->Domains->find('list', ['limit' => 200]);
        $vendors = $this->DomainsRecords->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('domainsRecord', 'domains', 'vendors'));
        $this->set('_serialize', ['domainsRecord']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Domains Record id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $domainsRecord = $this->DomainsRecords->get($id);
        if ($this->DomainsRecords->delete($domainsRecord)) {
            $this->Flash->success(__('The domains record has been deleted.'));
        } else {
            $this->Flash->error(__('The domains record could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
