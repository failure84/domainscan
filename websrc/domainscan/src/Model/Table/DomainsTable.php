<?php
namespace App\Model\Table;

use App\Model\Entity\Domain;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Domains Model
 *
 */
class DomainsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('domains');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
	$this->addBehavior('Sphinx.Sphinx', [
				'host' => 'localhost', 'port' => '9306', 'defaultIndex' => 'domains1']);


	$this->hasMany('DomainsRecords', [
            'foreignKey' => 'domain_id',
            'dependent' => true,
	]);
	$this->belongsTo('Vendors');

    }
    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        return $validator;
    }
}
