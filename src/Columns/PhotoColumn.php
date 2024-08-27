<?php

namespace Ta3leem\PhotoColumn\Columns;

use Filament\Tables\Columns\Column;

// TODO: you should make it works. make it a package
class PhotoColumn extends Column
{
    protected string $view = 'photo-column::photo-column';

    protected function setUp(): void
    {
        parent::setUp();

        $this->disabledClick();
    }
}
