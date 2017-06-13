<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Domains Controller
 *
 * @property \App\Model\Table\DomainsTable $Domains
 */
class DomainsController extends AppController
{
	public $paginate = [
	// Other keys here.
	'limit' => 50,
	'order' => [
            'new_mx' => 'DESC'
	],
	];

    /**
     * Index method
     *
     * @return void
     */
    public function index($search = null)
    {
	$search = $this->request->query('search');
	$vendors_id = $this->request->query('vendors_id');



	if (!$vendors_id) {
		$vendors_search = array();
	} else {
		$vendors_search = [ 'vendor_id' => $vendors_id ];
	}

	if(!$search){
		$query = $this->Domains->find(); 
	} else {
		$query = $this->Domains->search(['index' => 'domains1', 
					    'term' => $search, 
					    'match_fields' => 'name', 
					    'limit' => '50'
		]);
	}


	$query->where([$vendors_search]);
	$query->contain([
		'Vendors' => function ($q) {
			return $q
			->select(['id', 'name']);
    	}]);
	$query->select(['id', 'name', 'new_mx']);
	$this->set('search', $search);
	$this->set('vendors_id', $vendors_id);
	$vendors = $this->Domains->Vendors->find('list', array(
						'fields'=>array('id','name')));
	$this->set('vendors', $vendors);
	$this->set('_serialize', ['domains']);
	if ($query->count() > 0) {
		$this->Flash->success("Found " . $query->count() . " Domains");
	} else {
		$this->Flash->error("$search Not Found");
	}

	if($this->request->query){
		$this->set('domains', $this->paginate($query));
	}
    }

    /**
     * View method
     *
     * @param string|null $id Domain id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $domain = $this->Domains->get($id, [
            'contain' => [
		'DomainsRecords' => [
			'queryBuilder' => function ($q) {
					return $q->order(['DomainsRecords.modified' => 'DESC']); 
				    },
			'Vendors']
		]
        ]);
        $this->set('domain', $domain);
        $this->set('_serialize', ['domain']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $domain = $this->Domains->newEntity();
        if ($this->request->is('post')) {
            $domain = $this->Domains->patchEntity($domain, $this->request->data);
            if ($this->Domains->save($domain)) {
                $this->Flash->success(__('The domain has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The domain could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('domain'));
        $this->set('_serialize', ['domain']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Domain id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $domain = $this->Domains->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $domain = $this->Domains->patchEntity($domain, $this->request->data);
            if ($this->Domains->save($domain)) {
                $this->Flash->success(__('The domain has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The domain could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('domain'));
        $this->set('_serialize', ['domain']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Domain id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
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
