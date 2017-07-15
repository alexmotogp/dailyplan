<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class TaskForm extends AbstractType {
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('name', null, array('label' => 'Задача:'))
			->add('description', null, array('label' => 'Описание:'))
			->add('executeData', DateType::class, array('label' => 'Дата:', 'widget' => 'single_text', 'placeholder' => 'sdf'))
			->add('submit', SubmitType::class, array('label' => 'Создать'));
	}
}