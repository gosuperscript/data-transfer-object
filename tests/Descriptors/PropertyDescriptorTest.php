<?php

namespace Spatie\DataTransferObject\Tests\Descriptors;

use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\Tests\Stubs\MappedDataTransferObject;
use Spatie\DataTransferObject\Tests\Stubs\SimpleDataTransferObject;
use Spatie\DataTransferObject\Tests\TestCase;

class PropertyDescriptorTest extends TestCase
{
    public function test_it_can_get_attributes(): void
    {
        $classDescriptor = $this->getDescriptor(MappedDataTransferObject::class);
        $propertyDescriptor = $classDescriptor->getProperty('mappedFromAttribute');

        $this->assertNotNull($propertyDescriptor);
        $this->assertInstanceOf(Collection::class, $propertyDescriptor->getAttributes());
        $this->assertContainsOnlyInstancesOf(MapFrom::class, $propertyDescriptor->getAttributes());
        $this->assertCount(1, $propertyDescriptor->getAttributes());
    }

    public function test_it_can_get_specific_attribute(): void
    {
        $classDescriptor = $this->getDescriptor(MappedDataTransferObject::class);
        $propertyDescriptor = $classDescriptor->getProperty('mappedFromAttribute');
        $attribute = $propertyDescriptor->getAttribute(MapFrom::class);

        $this->assertInstanceOf(MapFrom::class, $attribute);
    }

    public function test_it_can_get_name(): void
    {
        $classDescriptor = $this->getDescriptor(MappedDataTransferObject::class);

        $this->assertSame('mappedFromKey', $classDescriptor->getProperty('mappedFromKey')->getName());
        $this->assertSame('mappedFromAttribute', $classDescriptor->getProperty('mappedFromAttribute')->getName());
        $this->assertSame('mappedFromNested', $classDescriptor->getProperty('mappedFromNested')->getName());
    }

    public function test_it_can_manipulate_values(): void
    {
        $classDescriptor = $this->getDescriptor(SimpleDataTransferObject::class);
        $dataTransferObject = $classDescriptor->getDataTransferObject();

        $firstNameProperty = $classDescriptor->getProperty('firstName');
        $lastNameProperty = $classDescriptor->getProperty('lastName');

        $firstNameProperty->setValue('James');
        $this->assertSame('James', $firstNameProperty->getValue());
        $this->assertSame('James', $dataTransferObject->firstName);

        $lastNameProperty->setValue('Johnson');
        $this->assertSame('Johnson', $lastNameProperty->getValue());
        $this->assertSame('Johnson', $dataTransferObject->lastName);
    }
}
