<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vendors Model
 *
 * @property \App\Model\Table\DomainsTable&\Cake\ORM\Association\HasMany $Domains
 * @property &\Cake\ORM\Association\HasMany $DomainsRecords
 * @property \App\Model\Table\StatsTable&\Cake\ORM\Association\HasMany $Stats
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\HasMany $Users
 * @property \App\Model\Table\VendorsMxsTable&\Cake\ORM\Association\HasMany $VendorsMxs
 *
 * @method \App\Model\Entity\Vendor get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vendor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Vendor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vendor|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vendor saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vendor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vendor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vendor findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
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

        $this->setTable('vendors');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Domains', [
            'foreignKey' => 'vendor_id',
        ]);
        $this->hasMany('DomainsRecords', [
            'foreignKey' => 'vendor_id',
        ]);
        $this->hasMany('Stats', [
            'foreignKey' => 'vendor_id',
        ]);
        $this->hasMany('Users', [
            'foreignKey' => 'vendor_id',
        ]);
        $this->hasMany('VendorsMxs', [
            'foreignKey' => 'vendor_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->scalar('comment')
            ->requirePresence('comment', 'create')
            ->notEmptyString('comment');

        return $validator;
    }
}
