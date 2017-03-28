<?php
return [
    'service_manager' => [
        'factories' => [
            \ApigilitySocial\V1\Rest\Person\PersonResource::class => \ApigilitySocial\V1\Rest\Person\PersonResourceFactory::class,
            \ApigilitySocial\V1\Rest\Friend\FriendResource::class => \ApigilitySocial\V1\Rest\Friend\FriendResourceFactory::class,
            \ApigilitySocial\V1\Rest\Requirement\RequirementResource::class => \ApigilitySocial\V1\Rest\Requirement\RequirementResourceFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'apigility-social.rest.person' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/social/person[/:person_id]',
                    'defaults' => [
                        'controller' => 'ApigilitySocial\\V1\\Rest\\Person\\Controller',
                    ],
                ],
            ],
            'apigility-social.rest.friend' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/social/friend[/:friend_id]',
                    'defaults' => [
                        'controller' => 'ApigilitySocial\\V1\\Rest\\Friend\\Controller',
                    ],
                ],
            ],
            'apigility-social.rest.requirement' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/social/requirement[/:requirement_id]',
                    'defaults' => [
                        'controller' => 'ApigilitySocial\\V1\\Rest\\Requirement\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'zf-versioning' => [
        'uri' => [
            0 => 'apigility-social.rest.person',
            1 => 'apigility-social.rest.friend',
            2 => 'apigility-social.rest.requirement',
        ],
    ],
    'zf-rest' => [
        'ApigilitySocial\\V1\\Rest\\Person\\Controller' => [
            'listener' => \ApigilitySocial\V1\Rest\Person\PersonResource::class,
            'route_name' => 'apigility-social.rest.person',
            'route_identifier_name' => 'person_id',
            'collection_name' => 'person',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'user_id',
                1 => 'sex',
                2 => 'age_min',
                3 => 'age_max',
                4 => 'stature_min',
                5 => 'stature_max',
                6 => 'education',
                7 => 'emotion',
                8 => 'zodiac',
                9 => 'chinese_zodiac',
                10 => 'occupation',
                11 => 'income_level',
                12 => 'residence_address_province',
                13 => 'residence_address_city',
                14 => 'residence_address_district',
                15 => 'census_register_address_province',
                16 => 'census_register_address_city',
                17 => 'census_register_address_district',
                18 => 'vip',
                19 => 'personal_certification_status',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilitySocial\V1\Rest\Person\PersonEntity::class,
            'collection_class' => \ApigilitySocial\V1\Rest\Person\PersonCollection::class,
            'service_name' => 'Person',
        ],
        'ApigilitySocial\\V1\\Rest\\Friend\\Controller' => [
            'listener' => \ApigilitySocial\V1\Rest\Friend\FriendResource::class,
            'route_name' => 'apigility-social.rest.friend',
            'route_identifier_name' => 'friend_id',
            'collection_name' => 'friend',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [
                0 => 'user_id',
                1 => 'status',
            ],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilitySocial\V1\Rest\Friend\FriendEntity::class,
            'collection_class' => \ApigilitySocial\V1\Rest\Friend\FriendCollection::class,
            'service_name' => 'Friend',
        ],
        'ApigilitySocial\\V1\\Rest\\Requirement\\Controller' => [
            'listener' => \ApigilitySocial\V1\Rest\Requirement\RequirementResource::class,
            'route_name' => 'apigility-social.rest.requirement',
            'route_identifier_name' => 'requirement_id',
            'collection_name' => 'requirement',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \ApigilitySocial\V1\Rest\Requirement\RequirementEntity::class,
            'collection_class' => \ApigilitySocial\V1\Rest\Requirement\RequirementCollection::class,
            'service_name' => 'Requirement',
        ],
    ],
    'zf-content-negotiation' => [
        'controllers' => [
            'ApigilitySocial\\V1\\Rest\\Person\\Controller' => 'HalJson',
            'ApigilitySocial\\V1\\Rest\\Friend\\Controller' => 'HalJson',
            'ApigilitySocial\\V1\\Rest\\Requirement\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'ApigilitySocial\\V1\\Rest\\Person\\Controller' => [
                0 => 'application/vnd.apigility-social.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'ApigilitySocial\\V1\\Rest\\Friend\\Controller' => [
                0 => 'application/vnd.apigility-social.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'ApigilitySocial\\V1\\Rest\\Requirement\\Controller' => [
                0 => 'application/vnd.apigility-social.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'ApigilitySocial\\V1\\Rest\\Person\\Controller' => [
                0 => 'application/vnd.apigility-social.v1+json',
                1 => 'application/json',
            ],
            'ApigilitySocial\\V1\\Rest\\Friend\\Controller' => [
                0 => 'application/vnd.apigility-social.v1+json',
                1 => 'application/json',
            ],
            'ApigilitySocial\\V1\\Rest\\Requirement\\Controller' => [
                0 => 'application/vnd.apigility-social.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'zf-hal' => [
        'metadata_map' => [
            \ApigilitySocial\V1\Rest\Person\PersonEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-social.rest.person',
                'route_identifier_name' => 'person_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilitySocial\V1\Rest\Person\PersonCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-social.rest.person',
                'route_identifier_name' => 'person_id',
                'is_collection' => true,
            ],
            \ApigilitySocial\V1\Rest\Friend\FriendEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-social.rest.friend',
                'route_identifier_name' => 'friend_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilitySocial\V1\Rest\Friend\FriendCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-social.rest.friend',
                'route_identifier_name' => 'friend_id',
                'is_collection' => true,
            ],
            \ApigilitySocial\V1\Rest\Requirement\RequirementEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-social.rest.requirement',
                'route_identifier_name' => 'requirement_id',
                'hydrator' => \Zend\Hydrator\ClassMethods::class,
            ],
            \ApigilitySocial\V1\Rest\Requirement\RequirementCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'apigility-social.rest.requirement',
                'route_identifier_name' => 'requirement_id',
                'is_collection' => true,
            ],
        ],
    ],
];
