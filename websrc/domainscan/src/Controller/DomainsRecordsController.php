<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DomainsRecords Controller
 *
 * @property \App\Model\Table\DomainsRecordsTable $DomainsRecords
 *
 * @method \App\Model\Entity\DomainsRecord[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DomainsRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Domains', 'Vendors'],
        ];
        $domainsRecords = $this->paginate($this->DomainsRecords);

        $this->set(compact('domainsRecords'));
    }

    /**
     * View method
     *
     * @param string|null $id Domains Record id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $domainsRecord = $this->DomainsRecords->get($id, [
            'contain' => ['Domains', 'Vendors'],
        ]);

        $this->set('domainsRecord', $domainsRecord);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $domainsRecord = $this->DomainsRecords->newEntity();
        if ($this->request->is('post')) {
            $domainsRecord = $this->DomainsRecords->patchEntity($domainsRecord, $this->request->getData());
            if ($this->DomainsRecords->save($domainsRecord)) {
                $this->Flash->success(__('The domains record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The domains record could not be saved. Please, try again.'));
        }
        $domains = $this->DomainsRecords->Domains->find('list', ['limit' => 200]);
        $vendors = $this->DomainsRecords->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('domainsRecord', 'domains', 'vendors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Domains Record id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $domainsRecord = $this->DomainsRecords->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $domainsRecord = $this->DomainsRecords->patchEntity($domainsRecord, $this->request->getData());
            if ($this->DomainsRecords->save($domainsRecord)) {
                $this->Flash->success(__('The domains record has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The domains record could not be saved. Please, try again.'));
        }
        $domains = $this->DomainsRecords->Domains->find('list', ['limit' => 200]);
        $vendors = $this->DomainsRecords->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('domainsRecord', 'domains', 'vendors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Domains Record id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
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
