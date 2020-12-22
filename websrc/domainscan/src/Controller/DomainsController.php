<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Domains Controller
 *
 * @property \App\Model\Table\DomainsTable $Domains
 *
 * @method \App\Model\Entity\Domain[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DomainsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function getindex()
    {
        $this->request->allowMethod('ajax');
        $this->paginate = [
            'contain' => ['Vendors'],
            'order' => [ 'new_mx' => 'desc' ]
        ];

        if ($this->request->getQuery('q') !== null) {
            $domains = $this->Domains->find('search', ['search' => $this->request->getQueryParams()]);
        }
        else {
            $domains = $this->Domains->find();
        }

        $this->set('domains', $this->paginate($domains));
    }

    /**
     * View method
     *
     * @param string|null $id Domain id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $domain = $this->Domains->get($id, [
            'contain' => ['Vendors', 'DomainsRecords'],
        ]);

        $this->set('domain', $domain);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $domain = $this->Domains->newEntity();
        if ($this->request->is('post')) {
            $domain = $this->Domains->patchEntity($domain, $this->request->getData());
            if ($this->Domains->save($domain)) {
                $this->Flash->success(__('The domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The domain could not be saved. Please, try again.'));
        }
        $vendors = $this->Domains->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('domain', 'vendors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Domain id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $domain = $this->Domains->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $domain = $this->Domains->patchEntity($domain, $this->request->getData());
            if ($this->Domains->save($domain)) {
                $this->Flash->success(__('The domain has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The domain could not be saved. Please, try again.'));
        }
        $vendors = $this->Domains->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('domain', 'vendors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Domain id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $domain = $this->Domains->get($id);
        if ($this->Domains->delete($domain)) {
            $this->Flash->success(__('The domain has been deleted.'));
        } else {
            $this->Flash->error(__('The domain could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
