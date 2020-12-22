<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Domain Entity
 *
 * @property int $id
 * @property string $name
 * @property int $errors
 * @property \Cake\I18n\Time|null $new_mx
 * @property int $vendor_id
 * @property string $note
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 *
 * @property \App\Model\Entity\DomainsRecord[] $domains_records
 * @property \App\Model\Entity\Vendor $vendor
 */
class Domain extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'errors' => true,
        'new_mx' => true,
        'vendor_id' => true,
        'note' => true,
        'created' => true,
        'modified' => true,
        'domains_records' => true,
        'vendor' => true,
    ];
}
