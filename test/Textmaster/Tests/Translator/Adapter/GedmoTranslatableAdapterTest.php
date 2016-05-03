<?php

namespace Textmaster\Tests\Translator\Adapter;

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

        $translatableMock = $this->getMock('Gedmo\Translatable\Translatable', array('getName', 'getId'));
        $documentMock = $this->getMock('Textmaster\Model\Document', array('getProject', 'save'), array(), '', false);
        $projectMock = $this->getMock('Textmaster\Model\Project', array('getLanguageFrom'), array(), '', false);

        $translatableMock->expects($this->once())
            ->method('getName')
            ->willReturn('name');
        $translatableMock->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $documentMock->expects($this->once())
            ->method('getProject')
            ->willReturn($projectMock);
        $documentMock->expects($this->once())
            ->method('save')
            ->willReturn($documentMock);

        $projectMock->expects($this->once())
            ->method('getLanguageFrom')
            ->willReturn('en');

        $listenerMock->expects($this->once())
            ->method('getListenerLocale')
            ->willReturn('en');

        $adapter = new GedmoTranslatableAdapter($managerRegistryMock, $listenerMock);
        $adapter->create($translatableMock, array('name'), $documentMock);
    }

    /**
     * @test
     */
    public function shouldCreateDifferentLocale()
    {
        $managerRegistryMock = $this->getMock('Doctrine\Common\Persistence\ManagerRegistry');
        $listenerMock = $this->getMock('Gedmo\Translatable\TranslatableListener');

        $translatableMock = $this->getMock('Gedmo\Translatable\Translatable', array('setLocale', 'getName', 'getId'));
        $documentMock = $this->getMock('Textmaster\Model\Document', array('getProject', 'save'), array(), '', false);
        $projectMock = $this->getMock('Textmaster\Model\Project', array('getLanguageFrom'), array(), '', false);
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
        $documentMock->expects($this->once())
            ->method('save')
            ->willReturn($documentMock);

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
        $adapter->create($translatableMock, array('name'), $documentMock);
    }
}
