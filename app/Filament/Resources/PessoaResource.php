<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Cidade;
use App\Models\Estado;
use App\Models\Pessoa;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Collection;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PessoaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PessoaResource\RelationManagers;

class PessoaResource extends Resource
{
    protected static ?string $model = Pessoa::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('nome')
                        ->required()
                        ->maxLength(125)
                        ->columnspan(3),
                    Forms\Components\DatePicker::make('dt_nascimento')
                        ->required()
                        ->columnspan(1),
                    Forms\Components\TextInput::make('estado_civil')
                        ->required()
                        ->maxLength(125)
                        ->columnspan(1),
                    Forms\Components\TextInput::make('sexo')
                        ->required()
                        ->maxLength(125)
                        ->columnspan(1),
                ])
                ->columns(3),
                Card::make()->schema([
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(125)
                        ->columnspan(2),
                    Forms\Components\TextInput::make('telefone')
                        ->tel()
                        ->required()
                        ->maxLength(125)
                        ->placeholder('(xx)xxxxx-xxxx')
                        ->mask('(99)99999-9999')
                        ->columnspan(1),
                ])
                ->columns(3),
                Card::make()->schema([
                        Forms\Components\TextInput::make('cpf')
                            ->required()
                            ->maxLength(125)
                            ->placeholder('xxx.xxx.xxx-xx')
                            ->mask('999.999.999-99')
                            ->columnspan(1),
                        Forms\Components\TextInput::make('rg')
                            ->required()
                            ->maxLength(125)
                            ->placeholder('xxxxxxxxxx')
                            ->mask('9999999999')
                            ->columnspan(1),
                        Forms\Components\TextInput::make('nis')
                            ->required()
                            ->maxLength(125)
                            ->placeholder('xxx.xxxxx.xx-x')
                            ->mask('999.99999.99-9')
                            ->columnspan(1),
                ])
                ->columns(3),
                Card::make()->schema([
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
                        ->live()
                        ->afterStateUpdated(fn(Set $set) => $set('cidade_id', null)),
                    Select::make('cidade_id')
                        ->options(fn(Get $get): Collection => Cidade::query()
                        ->where ('estado_id', $get('estado_id'))
                        ->pluck('name','id'))
                        ->preload()
                        ->label('Cidade')
                        ->live(),
                    Forms\Components\TextInput::make('rua')
                        ->required()
                        ->maxLength(125),
                    Forms\Components\TextInput::make('cep')
                        ->required()
                        ->maxLength(125)
                        ->placeholder('xxxxx-xxx')
                        ->mask('99999-999'),
                    Forms\Components\TextInput::make('complemento')
                        ->maxLength(125),
                    Forms\Components\TextInput::make('Bairro')
                        ->required()
                        ->maxLength(125),
                    Forms\Components\TextInput::make('numero')
                        ->required()
                        ->numeric(),
                ])
                ->columns(3),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('dt_nascimento')
                    ->date('d/m/Y')
                    ->label('Data Nascimento')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPessoas::route('/'),
            'create' => Pages\CreatePessoa::route('/create'),
            'edit' => Pages\EditPessoa::route('/{record}/edit'),
        ];
    }
}
