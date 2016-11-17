<?php

/*
 * This file is part of the Textmaster Api v1 client package.
 *
 * (c) Christian Daguerre <christian@daguer.re>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Textmaster\Unit\Translator\Adapter;

use Textmaster\Model\ProjectInterface;
use Textmaster\Translator\Adapter\SyliusTranslatableAdapter;
use Textmaster\Unit\Mock\MockTranslation;

/**
 * @group sylius
 */
class SyliusTranslatableAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldSupportTranslatable()
    {
        $managerRegistryMock = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $translatableMock = $this->getMock('Sylius\Component\Resource\Model\TranslatableInterface');
        $adapter = new SyliusTranslatableAdapter($managerRegistryMock);

        $this->assertTrue($adapter->supports($translatableMock));
    }

    /**
     * @test
     */
    public function shouldNotSupportNotTranslatable()
    {
        $managerRegistryMock = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $translatableMock = $this->getMock('Sylius\Component\Resource\Model\NotTranslatableInterface');
        $adapter = new SyliusTranslatableAdapter($managerRegistryMock);

        $this->assertFalse($adapter->supports($translatableMock));
    }

    /**
     * @test
     */
    public function shouldCreate()
    {
        $managerRegistryMock = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $translatableMock = $this->getMock('Sylius\Component\Resource\Model\TranslatableInterface', ['getId', 'translate', 'hasTranslation', 'setCurrentLocale', 'setFallbackLocale', 'getTranslations', 'addTranslation', 'removeTranslation']);
        $translationMock = new MockTranslation();
        $translationMock->setName('Translated name');
        $documentMock = $this->getMock('Textmaster\Model\Document', ['getProject', 'save'], [], '', false);
        $projectMock = $this->getMock('Textmaster\Model\Project', ['getLanguageFrom'], [], '', false);

        $documentMock->expects($this->once())
            ->method('getProject')
            ->willReturn($projectMock);

        $projectMock->expects($this->once())
            ->method('getLanguageFrom')
            ->willReturn('en');

        $translatableMock->expects($this->once())
            ->method('translate')
            ->willReturn($translationMock);
        $translatableMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $adapter = new SyliusTranslatableAdapter($managerRegistryMock);
        $adapter->push($translatableMock, ['name'], $documentMock);
    }

    /**
     * @test
     */
    public function shouldComplete()
    {
        $managerRegistryMock = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $objectManagerMock = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectRepositoryMock = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');

        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');
        $projectMock = $this->getMock('Textmaster\Model\ProjectInterface');

        $translatableMock = $this->getMock('Sylius\Component\Resource\Model\TranslatableInterface', ['getId', 'translate', 'hasTranslation', 'setCurrentLocale', 'setFallbackLocale', 'getTranslations', 'addTranslation', 'removeTranslation']);
        $translationMock = new MockTranslation();

        $documentMock->expects($this->once())
            ->method('getCustomData')
            ->willReturn(['class' => 'My\Class', 'id' => 1]);
        $documentMock->expects($this->once())
            ->method('getSourceContent')
            ->willReturn(['name' => 'my translation']);
        $documentMock->expects($this->once())
            ->method('getProject')
            ->willReturn($projectMock);

        $managerRegistryMock->expects($this->exactly(2))
            ->method('getManagerForClass')
            ->will($this->returnValue($objectManagerMock));

        $objectManagerMock->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($objectRepositoryMock));

        $objectRepositoryMock->expects($this->once())
            ->method('find')
            ->willReturn($translatableMock);

        $translatableMock->expects($this->once())
            ->method('translate')
            ->willReturn($translationMock);

        $projectMock->expects($this->once())
            ->method('getLanguageTo')
            ->willReturn('fr');

        $projectMock->expects($this->once())
            ->method('getActivity')
            ->willReturn(ProjectInterface::ACTIVITY_TRANSLATION);

        $adapter = new SyliusTranslatableAdapter($managerRegistryMock);
        $subject = $adapter->pull($documentMock);

        $this->assertSame($translatableMock, $subject);
        $this->assertSame('my translation', $translationMock->getName());
    }

    /**
     * @test
     */
    public function shouldCompare()
    {
        $managerRegistryMock = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');

        $objectManagerMock = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $objectRepositoryMock = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $documentMock = $this->getMock('Textmaster\Model\DocumentInterface');
        $translatableMock = $this->getMock('Sylius\Component\Resource\Model\TranslatableInterface');
        $projectMock = $this->getMock('Textmaster\Model\ProjectInterface');
        $enTranslationMock = new MockTranslation();
        $enTranslationMock->setName('Name to translate');
        $frTranslationMock = new MockTranslation();

        $documentMock->expects($this->once())
            ->method('getCustomData')
            ->willReturn(['class' => 'My\Class', 'id' => 1]);
        $documentMock->expects($this->once())
            ->method('getOriginalContent')
            ->willReturn(['name' => ['original_phrase' => 'Name to translate']]);
        $documentMock->expects($this->once())
            ->method('getSourceContent')
            ->willReturn(['name' => 'Le nom à traduire']);
        $documentMock->expects($this->once())
            ->method('getProject')
            ->willReturn($projectMock);

        $projectMock->expects($this->once())
            ->method('getLanguageFrom')
            ->willReturn('en');
        $projectMock->expects($this->once())
            ->method('getLanguageTo')
            ->willReturn('fr');
        $projectMock->expects($this->exactly(2))
            ->method('getActivity')
            ->willReturn(ProjectInterface::ACTIVITY_TRANSLATION);

        $managerRegistryMock->expects($this->once())
            ->method('getManagerForClass')
            ->will($this->returnValue($objectManagerMock));

        $objectManagerMock->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($objectRepositoryMock));

        $objectRepositoryMock->expects($this->once())
            ->method('find')
            ->willReturn($translatableMock);

        $map = [
            ['en', $enTranslationMock],
            ['fr', $frTranslationMock],
        ];
        $translatableMock->expects($this->exactly(2))
            ->method('translate')
            ->will($this->returnValueMap($map));

        $adapter = new SyliusTranslatableAdapter($managerRegistryMock);
        $comparison = $adapter->compare($documentMock);

        $this->assertSame(['name' => ''], $comparison['original']);
        $this->assertContains('Le nom à traduire', $comparison['translated']['name']);
    }
}
