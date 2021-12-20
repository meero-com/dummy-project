<?php

declare(strict_types=1);

namespace App\Tests\Utils;

use App\Utils\DummyUserCreator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class DummyUserCreatorTest extends TestCase
{
    /** @test */
    public function it_creates_10_users(): void
    {
        $stub = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalClone()
            ->disableOriginalConstructor()
            ->disableArgumentCloning()
            ->getMock()
        ;

        $stub
            ->expects(self::exactly(10))
            ->method('persist')
            ->withAnyParameters()
        ;

        $stub
            ->expects(self::exactly(10))
            ->method('flush')
        ;

        $dummyUserCreator = new DummyUserCreator($stub);

        $dummyUserCreator->create(10);
    }

    /** @test */
    public function it_creates_no_user_when_argument_is_negative(): void
    {
        $stub = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalClone()
            ->disableOriginalConstructor()
            ->disableArgumentCloning()
            ->getMock()
        ;

        $stub
            ->expects(self::exactly(0))
            ->method('persist')
            ->withAnyParameters()
        ;

        $stub
            ->expects(self::exactly(0))
            ->method('flush')
        ;

        $dummyUserCreator = new DummyUserCreator($stub);

        $this->assertFalse($dummyUserCreator->create(-1));
    }
}
