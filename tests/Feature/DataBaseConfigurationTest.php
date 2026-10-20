<?php

namespace Tests\Feature;

use Tests\TestCase;

class DatabaseConfigurationTest extends TestCase
{
    public function test_uses_sqlite_in_memory_database(): void
    {
        $this->assertSame(
            'sqlite',
            config('database.default'),
            'Las pruebas deben utilizar SQLite, no MySQL.'
        );

        $this->assertSame(
            ':memory:',
            config('database.connections.sqlite.database'),
            'Las pruebas deben utilizar una base SQLite en memoria.'
        );
    }
}