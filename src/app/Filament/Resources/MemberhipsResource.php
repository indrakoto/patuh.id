<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberhipsResource\Pages;
use App\Filament\Resources\MemberhipsResource\RelationManagers;
use App\Models\UserMembership;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Michaeld555\FilamentCroppie\Components\Croppie;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Forms\Components\Grid;

class MemberhipsResource extends Resource
{
    protected static ?string $model = UserMembership::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('user.name')->searchable()->sortable(),
                TextColumn::make('membershipPlan.name')->limit(30),
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
            'index' => Pages\ListMemberhips::route('/'),
            'create' => Pages\CreateMemberhips::route('/create'),
            'edit' => Pages\EditMemberhips::route('/{record}/edit'),
        ];
    }
}
