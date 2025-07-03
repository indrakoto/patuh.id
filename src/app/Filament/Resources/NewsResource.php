<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use App\Models\Category;
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

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel   = 'Berita';
    protected static ?string $navigationGroup = 'Master';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([
                    Grid::make([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                    ])->schema([
                        TextInput::make('title')
                                ->label('Nama Berita')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                                ,
                        SelectTree::make('category_id')
                            ->label('Kategori')
                            ->withCount()
                            ->relationship('category', 'name', 'parent', fn($query) => $query->where('id', 11))
                            ->required(),
                        TextInput::make('slug')
                    ]),

                    Grid::make([
                        'sm' => 1,
                        'md' => 1,
                        'lg' => 2,
                    ])->schema([
                        RichEditor::make('content')
                            ->label('Deskripsi')
                            ->required()
                            ->columns(3),

                        Croppie::make('thumbnail')
                            ->label('Featured')
                            ->disk('thumbnails_path')
                            ->viewportType('square')
                            ->viewportHeight(412)
                            ->viewportWidth(704)
                            ->boundaryHeight(500)
                            ->boundaryWidth(800)
                            ->enableZoom(true)
                            ->imageFormat('png')
                            ->imageName('thumb_'),
                    ]),

                    Forms\Components\Toggle::make('is_published')
                        ->label('Published'),
                ])

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('slug')->limit(30),
                TextColumn::make('category.name')->label('Category')->sortable(),
                //BooleanColumn::make('is_published')->label('Published'),
                //TextColumn::make('views')->label('Views')->sortable(),
                //TextColumn::make('created_at')->dateTime()->sortable(),
                //TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
