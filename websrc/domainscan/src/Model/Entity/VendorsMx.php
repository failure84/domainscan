<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorsMx Entity
 *
 * @property int $id
 * @property int $vendor_id
 * @property string|null $value
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 *
 * @property \App\Model\Entity\Vendor $vendor
 */
class VendorsMx extends Entity
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
        'vendor_id' => true,
        'value' => true,
        'created' => true,
        'modified' => true,
        'vendor' => true,
    ];
}
