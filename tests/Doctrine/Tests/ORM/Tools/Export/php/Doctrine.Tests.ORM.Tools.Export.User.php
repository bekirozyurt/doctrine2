<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Tests\ORM\Tools\Export;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(
    [
   'name' => 'cms_users',
   'options' => ['engine' => 'MyISAM', 'foo' => ['bar' => 'baz']],
    ]
);
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->addLifecycleCallback('doStuffOnPrePersist', 'prePersist');
$metadata->addLifecycleCallback('doOtherStuffOnPrePersistToo', 'prePersist');
$metadata->addLifecycleCallback('doStuffOnPostPersist', 'postPersist');
$metadata->mapField(
    [
   'id' => true,
   'fieldName' => 'id',
   'type' => 'integer',
   'columnName' => 'id',
    ]
);
$metadata->mapField(
    [
   'fieldName' => 'name',
   'type' => 'string',
   'length' => 50,
   'unique' => true,
   'nullable' => true,
   'columnName' => 'name',
    ]
);
$metadata->mapField(
    [
   'fieldName' => 'email',
   'type' => 'string',
   'columnName' => 'user_email',
   'columnDefinition' => 'CHAR(32) NOT NULL',
    ]
);
$metadata->mapField(
    [
   'fieldName' => 'age',
   'type' => 'integer',
   'options' => ["unsigned"=>true],
    ]
);
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);
$metadata->mapManyToOne(
    [
    'fieldName' => 'mainGroup',
    'targetEntity' => Export\Group::class,
    ]
);
$metadata->mapOneToOne(
    [
   'fieldName' => 'address',
   'targetEntity' => Export\Address::class,
   'inversedBy' => 'user',
   'cascade' =>
   [
   0 => 'persist',
   ],
   'mappedBy' => NULL,
   'joinColumns' =>
   [
   0 =>
   [
    'name' => 'address_id',
    'referencedColumnName' => 'id',
    'onDelete' => 'CASCADE',
   ],
   ],
   'orphanRemoval' => true,
   'fetch' => ClassMetadataInfo::FETCH_EAGER,
    ]
);
$metadata->mapOneToOne(
    [
    'fieldName' => 'cart',
    'targetEntity' => Export\Cart::class,
    'mappedBy' => 'user',
    'cascade' =>
        [
            0 => 'persist',
        ],
    'inversedBy' => NULL,
    'orphanRemoval' => false,
    'fetch' => ClassMetadataInfo::FETCH_EAGER,
    ]
);
$metadata->mapOneToMany(
    [
   'fieldName' => 'phonenumbers',
   'targetEntity' => Export\Phonenumber::class,
   'cascade' =>
   [
   1 => 'persist',
   2 => 'merge',
   ],
   'mappedBy' => 'user',
   'orphanRemoval' => true,
   'fetch' => ClassMetadataInfo::FETCH_LAZY,
   'orderBy' =>
   [
   'number' => 'ASC',
   ],
    ]
);
$metadata->mapManyToMany(
    [
   'fieldName' => 'groups',
   'targetEntity' => Export\Group::class,
   'fetch' => ClassMetadataInfo::FETCH_EXTRA_LAZY,
   'cascade' =>
   [
   0 => 'remove',
   1 => 'persist',
   2 => 'refresh',
   3 => 'merge',
   4 => 'detach',
   ],
   'mappedBy' => NULL,
   'joinTable' =>
   [
   'name' => 'cms_users_groups',
   'joinColumns' =>
   [
    0 =>
    [
    'name' => 'user_id',
    'referencedColumnName' => 'id',
    'unique' => false,
    'nullable' => false,
    ],
   ],
   'inverseJoinColumns' =>
   [
    0 =>
    [
    'name' => 'group_id',
    'referencedColumnName' => 'id',
    'columnDefinition' => 'INT NULL',
    ],
   ],
   ],
   'orderBy' => NULL,
    ]
);
