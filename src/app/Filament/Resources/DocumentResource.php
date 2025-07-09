<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Michaeld555\FilamentCroppie\Components\Croppie;
use CodeWithDennis\FilamentSelectTree\SelectTree;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Notifications\Notification;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationLabel   = 'Dokumen';
    protected static ?string $navigationGroup = 'Master';
    protected static ?int $navigationSort = 2;
    public static function shouldRegisterNavigation(): bool
    {
        //dd(auth()->user()->role);
        return auth()->check(); // semua user login bisa lihat
        //$user = auth()->user();
        //return $user && ($user->role('admin'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->schema([
                    TextInput::make('title')
                        ->label('Nama Dokumen')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                    TextInput::make('slug'),

                    SelectTree::make('category_id')
                        ->label('Kategori')
                        ->withCount()
                        ->relationship('categories', 'name', 'parent')
                        ->required(),
                   
                    RichEditor::make('description')
                        ->label('Deskripsi')
                        ->required()
                        ->columnSpanFull(),

                    FileUpload::make('file_path')
                        ->label('PDF File')
                        ->acceptedFileTypes(['application/pdf'])
                        ->required()
                        ->disk('private_uploads') // gunakan disk private
                        ->afterStateUpdated(function (?string $state, callable $set, ?UploadedFile $record) {
                            if ($record) {
                                $set('file_name', $record->getClientOriginalName());
                                $set('file_size', $record->getSize()); // dalam byte
                                $set('file_type', $record->getMimeType());
                            }
                        }),

                    Croppie::make('thumbnail_path')
                        ->disk('thumbnails_doc')
                        ->viewportType('square')
                        ->viewportHeight(412)
                        ->viewportWidth(704)
                        ->boundaryHeight(500)
                        ->boundaryWidth(800)
                        ->enableZoom(true)
                        ->imageFormat('png')
                        ->imageName('thumb_'),

                    Toggle::make('is_public')
                        ->label('Private - Public')
                        ->onIcon('heroicon-m-lock-open')
                        ->offIcon('heroicon-m-lock-closed')
                        ->onColor('success')
                        ->offColor('danger')
                        ->required(),
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->limit(80)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('categories.name')->label('Category')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
            //'view' => Pages\ViewDocument::route('/{record}'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('title')->label('Judul Dokumen'),
                TextEntry::make('description')->label('Deskripsi'),
                
                // Tambahkan ViewEntry untuk link dokumen
                ViewEntry::make('file_path')
                    ->label('Dokumen')
                    ->view('filament.infolists.entries.document-link'),
            ]);
    }

}
