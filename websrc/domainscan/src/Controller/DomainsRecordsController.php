<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Domainsrecords Controller
 *
 * @property \App\Model\Table\DomainsrecordsTable $Domainsrecords
 */
class DomainsrecordsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('domainsrecords', $this->paginate($this->Domainsrecords));
        $this->set('_serialize', ['domainsrecords']);
    }

    /**
     * View method
     *
     * @param string|null $id Domainsrecord id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $domainsrecord = $this->Domainsrecords->get($id, [
            'contain' => []
        ]);
        $this->set('domainsrecord', $domainsrecord);
        $this->set('_serialize', ['domainsrecord']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $domainsrecord = $this->Domainsrecords->newEntity();
        if ($this->request->is('post')) {
            $domainsrecord = $this->Domainsrecords->patchEntity($domainsrecord, $this->request->data);
            if ($this->Domainsrecords->save($domainsrecord)) {
                $this->Flash->success(__('The domainsrecord has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The domainsrecord could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('domainsrecord'));
        $this->set('_serialize', ['domainsrecord']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Domainsrecord id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $domainsrecord = $this->Domainsrecords->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $domainsrecord = $this->Domainsrecords->patchEntity($domainsrecord, $this->request->data);
            if ($this->Domainsrecords->save($domainsrecord)) {
                $this->Flash->success(__('The domainsrecord has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The domainsrecord could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('domainsrecord'));
        $this->set('_serialize', ['domainsrecord']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Domainsrecord id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $domainsrecord = $this->Domainsrecords->get($id);
        if ($this->Domainsrecords->delete($domainsrecord)) {
            $this->Flash->success(__('The domainsrecord has been deleted.'));
        } else {
            $this->Flash->error(__('The domainsrecord could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
