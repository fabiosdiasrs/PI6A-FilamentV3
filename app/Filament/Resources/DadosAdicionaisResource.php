<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Aluno;
use App\Models\Pessoa;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DadosAdicionais;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DadosAdicionaisResource\Pages;
use App\Filament\Resources\DadosAdicionaisResource\RelationManagers;

class DadosAdicionaisResource extends Resource
{
    protected static ?string $model = DadosAdicionais::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->schema([

                    Select::make('aluno_id')
                        ->relationship('aluno','nome')
                            ->required(),
                    Select::make('pessoa_id')
                            ->label('Responsável')
                            ->relationship('pessoa','nome'),
                    TextInput::make('parentesco_resp')
                                ->required()
                                ->maxLength(125),
                    TextInput::make('escola')
                        ->required()
                        ->maxLength(125),
                    TextInput::make('renda_familiar')
                        ->numeric(),
                ]),
                Grid::make()->schema([
                    Toggle::make('irmao_instituicao')
                        ->required(),
                    Toggle::make('bolsa_familia')
                        ->required(),
                    Toggle::make('direito_imagem')
                        ->required(),
                ])->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pessoa.nome')
                    ->label('Responsável')
                    ->sortable(),
                TextColumn::make('parentesco_resp')
                    ->label('Grau Parentesco')
                    ->searchable(),
                TextColumn::make('aluno.nome')
                    ->label('Aluno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('escola')
                    ->searchable(),
                TextColumn::make('renda_familiar')
                    ->numeric()
                    ->sortable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDadosAdicionais::route('/'),
            'create' => Pages\CreateDadosAdicionais::route('/create'),
            'edit' => Pages\EditDadosAdicionais::route('/{record}/edit'),
        ];
    }
}
