<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * VendorsMxs Controller
 *
 * @property \App\Model\Table\VendorsMxsTable $VendorsMxs
 *
 * @method \App\Model\Entity\VendorsMx[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class VendorsMxsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Vendors'],
        ];
        $vendorsMxs = $this->paginate($this->VendorsMxs);

        $this->set(compact('vendorsMxs'));
    }

    /**
     * View method
     *
     * @param string|null $id Vendors Mx id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendorsMx = $this->VendorsMxs->get($id, [
            'contain' => ['Vendors'],
        ]);

        $this->set('vendorsMx', $vendorsMx);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vendorsMx = $this->VendorsMxs->newEntity();
        if ($this->request->is('post')) {
            $vendorsMx = $this->VendorsMxs->patchEntity($vendorsMx, $this->request->getData());
            if ($this->VendorsMxs->save($vendorsMx)) {
                $this->Flash->success(__('The vendors mx has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendors mx could not be saved. Please, try again.'));
        }
        $vendors = $this->VendorsMxs->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('vendorsMx', 'vendors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendors Mx id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vendorsMx = $this->VendorsMxs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendorsMx = $this->VendorsMxs->patchEntity($vendorsMx, $this->request->getData());
            if ($this->VendorsMxs->save($vendorsMx)) {
                $this->Flash->success(__('The vendors mx has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The vendors mx could not be saved. Please, try again.'));
        }
        $vendors = $this->VendorsMxs->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('vendorsMx', 'vendors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendors Mx id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendorsMx = $this->VendorsMxs->get($id);
        if ($this->VendorsMxs->delete($vendorsMx)) {
            $this->Flash->success(__('The vendors mx has been deleted.'));
        } else {
            $this->Flash->error(__('The vendors mx could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
