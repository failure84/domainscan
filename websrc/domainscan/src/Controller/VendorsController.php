<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Cache\Cache;

/**
 * Vendors Controller
 *
 * @property \App\Model\Table\VendorsTable $Vendors
 */
class VendorsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
    $this->paginate = [
	'sortWhitelist' => [
		'id',
		'name',
		'created',
		'modified',
		'total_domains',
	],
	'limit' => '50',
	'order' => [
		'total_domains' => 'DESC'
	]
    ];

	$query = $this->Vendors->find(); 
	$query->select(['Vendors.id', 'Vendors.name', 'Vendors.created', 'Vendors.modified', 'total_domains' => $query->func()->count('Domains.id')])
        ->matching('Domains')
        ->group(['Domains.vendor_id']);

        $this->set('vendors', $this->Paginate($query));
        $this->set('_serialize', ['vendors']);
    }

    /**
     * View method
     *
     * @param string|null $id Vendor id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $vendor = $this->Vendors->get($id, [
            'contain' => ['VendorsMxs', 'Users', 'Stats']
        ]);

	$domains = $this->Vendors->Domains->find()->where(['vendor_id' => $id]);
	
	$this->set('domains', $this->Paginate($domains));
        $this->set('vendor', $vendor);
        $this->set('_serialize', ['vendor']);

	$domains_count = $this->Vendors->Domains->find()->where(['Domains.vendor_id' => $id])->count();
	$this->set('domains_count', $domains_count);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $vendor = $this->Vendors->newEntity();
        if ($this->request->is('post')) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('vendor'));
        $this->set('_serialize', ['vendor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Vendor id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $vendor = $this->Vendors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
            if ($this->Vendors->save($vendor)) {
                $this->Flash->success(__('The vendor has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The vendor could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('vendor'));
        $this->set('_serialize', ['vendor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Vendor id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $vendor = $this->Vendors->get($id);
        if ($this->Vendors->delete($vendor)) {
            $this->Flash->success(__('The vendor has been deleted.'));
        } else {
            $this->Flash->error(__('The vendor could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
