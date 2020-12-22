<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DomainsRecord Entity
 *
 * @property int $id
 * @property int $domain_id
 * @property int|null $vendor_id
 * @property string|null $name
 * @property int|null $value
 * @property string $type
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 *
 * @property \App\Model\Entity\Domain $domain
 * @property \App\Model\Entity\Vendor $vendor
 */
class DomainsRecord extends Entity
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
        'domain_id' => true,
        'vendor_id' => true,
        'name' => true,
        'value' => true,
        'type' => true,
        'created' => true,
        'modified' => true,
        'domain' => true,
        'vendor' => true,
    ];
}
