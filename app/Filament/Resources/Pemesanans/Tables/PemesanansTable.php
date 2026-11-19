<?php

namespace App\Filament\Resources\Pemesanans\Tables;

use App\Models\Pemesanan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PemesanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama Pemesan')->searchable(),
                TextColumn::make('tanggal')->date('d M Y')->sortable(),
                TextColumn::make('jam')->time('H:i'),
                TextColumn::make('raket')->label(Pemesanan::ALAT['raket'])->alignCenter(),
                TextColumn::make('sepatu')->label(Pemesanan::ALAT['sepatu'])->alignCenter(),
                TextColumn::make('bola')->label(Pemesanan::ALAT['bola'])->alignCenter(),
                TextColumn::make('total_bayar')->label('Total Bayar')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
