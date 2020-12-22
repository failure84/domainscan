<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string $comment
 * @property \Cake\I18n\Time|null $created
 * @property \Cake\I18n\Time|null $modified
 *
 * @property \App\Model\Entity\VendorsMx[] $vendors_mxs
 * @property \App\Model\Entity\Domain[] $domains
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Stat[] $stats
 */
class Vendor extends Entity
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
        'comment' => true,
        'created' => true,
        'modified' => true,
        'vendors_mxs' => true,
        'domains' => true,
        'users' => true,
        'stats' => true,
    ];
}
