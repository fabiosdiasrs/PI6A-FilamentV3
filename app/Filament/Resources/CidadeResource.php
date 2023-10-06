<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Pais;
use Filament\Tables;
use App\Models\Cidade;
use App\Models\Estado;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\CidadeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CidadeResource\RelationManagers;
use App\Filament\Resources\CidadeResource\Pages\ManageCidades;

class CidadeResource extends Resource
{
    protected static ?string $model = Cidade::class;
    /**
     * Função responsável pelo ícone da bandeja de navegação
     */
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Cadastros Auxiliares';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pais_id')
                    ->relationship('pais','name')
                        ->preload()
                        ->live()
                        ->afterStateUpdated(fn(Set $set) => $set('estado_id', null))
                        ->required(),
                Select::make('estado_id')
                    ->options(fn(Get $get): Collection => Estado::query()
                        ->where ('pais_id', $get('pais_id'))
                        ->pluck('name','id'))
                        ->preload()
                        ->label('Estado')
                        ->live(),
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(125),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pais.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('estado.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Cidade')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('pais')
                    ->relationship('pais','name'),
                SelectFilter::make('estado')
                    ->relationship('estado','name'),
            ])
            ->actions([
                EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCidades::route('/'),
        ];
    }
}
