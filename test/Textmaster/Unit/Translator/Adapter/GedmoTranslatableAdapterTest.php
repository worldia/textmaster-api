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

use Textmaster\Translator\Adapter\GedmoTranslatableAdapter;

class GedmoTranslatableAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldCreateSameLocale()
    {
        $managerRegistryMock = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $listenerMock = $this->getMock('Gedmo\Translatable\TranslatableListener');

        $translatableMock = $this->getMock('Gedmo\Translatable\Translatable', ['getName', 'getId']);
        $documentMock = $this->getMock('Textmaster\Model\Document', ['getProject', 'save'], [], '', false);
        $projectMock = $this->getMock('Textmaster\Model\Project', ['getLanguageFrom'], [], '', false);

        $translatableMock->expects($this->once())
            ->method('getName')
            ->willReturn('name');
        $translatableMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $documentMock->expects($this->once())
            ->method('getProject')
            ->willReturn($projectMock);

        $projectMock->expects($this->once())
            ->method('getLanguageFrom')
            ->willReturn('en');

        $listenerMock->expects($this->once())
            ->method('getListenerLocale')
            ->willReturn('en');

        $adapter = new GedmoTranslatableAdapter($managerRegistryMock, $listenerMock);
        $adapter->create($translatableMock, ['name'], $documentMock);
    }

    /**
     * @test
     */
    public function shouldCreateDifferentLocale()
    {
        $managerRegistryMock = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $listenerMock = $this->getMock('Gedmo\Translatable\TranslatableListener');

        $translatableMock = $this->getMock('Gedmo\Translatable\Translatable', ['setLocale', 'getName', 'getId']);
        $documentMock = $this->getMock('Textmaster\Model\Document', ['getProject', 'save'], [], '', false);
        $projectMock = $this->getMock('Textmaster\Model\Project', ['getLanguageFrom'], [], '', false);
        $entityManagerMock = $this->getMock('Doctrine\Common\Persistence\ObjectManager');

        $translatableMock->expects($this->once())
            ->method('getName')
            ->willReturn('name');
        $translatableMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $documentMock->expects($this->once())
            ->method('getProject')
            ->willReturn($projectMock);

        $projectMock->expects($this->once())
            ->method('getLanguageFrom')
            ->willReturn('en');

        $listenerMock->expects($this->once())
            ->method('getListenerLocale')
            ->willReturn('fr');

        $managerRegistryMock->expects($this->once())
            ->method('getManagerForClass')
            ->willReturn($entityManagerMock);

        $entityManagerMock->expects($this->once())
            ->method('refresh');

        $adapter = new GedmoTranslatableAdapter($managerRegistryMock, $listenerMock);
        $adapter->create($translatableMock, ['name'], $documentMock);
    }
}
