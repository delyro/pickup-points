<?php

declare(strict_types=1);

namespace App\Tests\Form;

use App\Form\DTO\Address;
use App\Form\PickupPointSearchType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class PickupPointSearchTypeTest extends TypeTestCase
{
    protected function getExtensions(): array
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAttributeMapping()
            ->getValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function testSubmitValidData(): void
    {
        $formData = [
            'city' => 'Kozy',
            'street' => 'Gajowa 27',
            'postalCode' => '43-340',
        ];

        $address = new Address();

        $form = $this->factory->create(PickupPointSearchType::class, $address);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'Form should be synchronized after submission.');
        $this->assertSame($address, $form->getData(), 'The form’s data should match the initial entity.');

        $this->assertEquals('Kozy', $address->city);
        $this->assertEquals('Gajowa 27', $address->street);
        $this->assertEquals('43-340', $address->postalCode);

        $view = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $field) {
            $this->assertArrayHasKey($field, $children, sprintf('Form should contain field "%s".', $field));
        }
    }

    public function testSubmitWithoutCity(): void
    {
        $formData = [
            'city' => '',
            'street' => 'Gajowa 27',
            'postalCode' => '43-340',
        ];

        $address = new Address();

        $form = $this->factory->create(PickupPointSearchType::class, $address);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'Even invalid data should not break form synchronization.');

        $this->assertFalse($form->isValid(), 'Form should be invalid with the given incorrect data.');
        $errors = $form->get('city')->getErrors(true);
        $this->assertCount(2, $errors);
        $this->assertEquals('This value should not be blank.', $errors[0]->getMessage());
        $this->assertSame('This value is too short. It should have 3 characters or more.', $errors[1]->getMessage());
    }

    public function testSubmitWithCityTooLong(): void
    {
        $formData = [
            'city' => 'Llanfairpwllgwyngyllgogerychwyrndrobwllllantysiliogogogoch_______',
            'street' => '',
            'postalCode' => '',
        ];

        $address = new Address();

        $form = $this->factory->create(PickupPointSearchType::class, $address);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'Even invalid data should not break form synchronization.');

        $this->assertFalse($form->isValid(), 'Form should be invalid with the given incorrect data.');
        $errors = $form->get('city')->getErrors(true);
        $this->assertCount(1, $errors);
        $this->assertEquals('This value is too long. It should have 64 characters or less.', $errors[0]->getMessage());
    }

    public function testSubmitWithStreetTooShort(): void
    {
        $formData = [
            'city' => 'Kozy',
            'street' => 'st',
            'postalCode' => '',
        ];

        $address = new Address();

        $form = $this->factory->create(PickupPointSearchType::class, $address);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'Even invalid data should not break form synchronization.');

        $this->assertFalse($form->isValid(), 'Form should be invalid with the given incorrect data.');
        $errors = $form->get('street')->getErrors(true);
        $this->assertCount(1, $errors);
        $this->assertEquals('This value is too short. It should have 3 characters or more.', $errors[0]->getMessage());
    }

    public function testSubmitWithStreetTooLong(): void
    {
        $formData = [
            'city' => 'Kozy',
            'street' => 'Andorijidoridaraemihansumbau_____________________________________',
            'postalCode' => '',
        ];

        $address = new Address();

        $form = $this->factory->create(PickupPointSearchType::class, $address);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'Even invalid data should not break form synchronization.');

        $this->assertFalse($form->isValid(), 'Form should be invalid with the given incorrect data.');
        $errors = $form->get('street')->getErrors(true);
        $this->assertCount(1, $errors);
        $this->assertEquals('This value is too long. It should have 64 characters or less.', $errors[0]->getMessage());
    }

    public function testSubmitPostalCodeIsRequiredWhenStreetIsFilled(): void
    {
        $formData = [
            'city' => 'Kozy',
            'street' => 'Gajowa 27',
            'postalCode' => '',
        ];

        $address = new Address();

        $form = $this->factory->create(PickupPointSearchType::class, $address);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'Even invalid data should not break form synchronization.');

        $this->assertFalse($form->isValid(), 'Form should be invalid with the given incorrect data.');
        $errors = $form->get('postalCode')->getErrors(true);
        $this->assertCount(1, $errors);
        $this->assertEquals('This value should not be blank.', $errors[0]->getMessage());
    }

    public function testSubmitPostalCodeHasInvalidPattern(): void
    {
        $formData = [
            'city' => 'Kozy',
            'street' => 'Gajowa 27',
            'postalCode' => '00000',
        ];

        $address = new Address();

        $form = $this->factory->create(PickupPointSearchType::class, $address);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'Even invalid data should not break form synchronization.');

        $this->assertFalse($form->isValid(), 'Form should be invalid with the given incorrect data.');
        $errors = $form->get('postalCode')->getErrors(true);
        $this->assertCount(1, $errors);
        $this->assertEquals('This value is not valid.', $errors[0]->getMessage());
    }

    public function testSubmitNameFieldIsAvailableWhenSpecificPostalCodeIsFilled(): void
    {
        $formData = [
            'city' => 'Kozy',
            'street' => 'Gajowa 27',
            'postalCode' => '01-234', // specific postal code to trigger additional field
        ];

        $address = new Address();

        $form = $this->factory->create(PickupPointSearchType::class, $address);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized(), 'Even invalid data should not break form synchronization.');

        $this->assertTrue($form->isValid(), 'Form should be invalid with the given incorrect data.');
        $this->assertTrue($form->has('name')); // additional field
    }
}
