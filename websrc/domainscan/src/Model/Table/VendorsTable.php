<?php
namespace App\Model\Table;

use App\Model\Entity\Vendor;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vendors Model
 *
 */
class VendorsTable extends Table
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

        $this->table('vendors');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('VendorsMxs', [
            'foreignKey' => 'vendor_id',
            'dependent' => true,
        ]);
#        $this->hasMany('DomainsRecords', [
#            'foreignKey' => 'vendor_id',
#            'dependent' => true,
#        ]);
        $this->hasMany('Domains', [
            'foreignKey' => 'vendor_id',
            'dependent' => true,
        ]);

        $this->hasMany('Users', [
            'foreignKey' => 'vendor_id',
            'dependent' => true,
        ]);


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
            ->allowEmpty('name');

        return $validator;
    }
}
