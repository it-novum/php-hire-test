<?php

namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Text;


class NullableBehavior extends Behavior
{
    protected $config = [
        'field' => 'description',
        'replacement' => null,
    ];

    public function nullText(EntityInterface $entity)
    {
        $value = $entity->get($this->config['field']);
        if ($value == "") {
            $entity->set($this->config['field'], $this->config['replacement']);
        }
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->nullText($entity);
    }
}
