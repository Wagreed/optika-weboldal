<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'Blog bejegyzések';
    protected static ?string $navigationGroup = 'Tartalom';
    protected static ?int $navigationSort = 90;
    protected static ?string $modelLabel = 'Blog bejegyzés';
    protected static ?string $pluralModelLabel = 'Blog bejegyzések';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tartalom')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->label('Cím'),
                        Forms\Components\TextInput::make('slug')
                            ->required(),
                        Forms\Components\Select::make('author_id')
                            ->relationship('author', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Szerző'),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Kategória'),
                        Forms\Components\Textarea::make('excerpt')
                            ->columnSpanFull()
                            ->label('Kivonat'),
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->columnSpanFull()
                            ->rows(10)
                            ->label('Tartalom'),
                    ])->columns(2),

                Forms\Components\Section::make('Publikálás')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Piszkozat',
                                'published' => 'Publikált',
                                'scheduled' => 'Ütemezett',
                                'archived' => 'Archivált',
                            ])
                            ->required()
                            ->label('Státusz'),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Publikálás időpontja'),
                        Forms\Components\FileUpload::make('featured_image')
                            ->image()
                            ->label('Kiemelt kép'),
                        Forms\Components\Textarea::make('tags')
                            ->label('Címkék'),
                    ])->columns(2),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->label('Meta cím'),
                        Forms\Components\Textarea::make('meta_description')
                            ->columnSpanFull()
                            ->label('Meta leírás'),
                    ])->columns(2)->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Cím'),
                Tables\Columns\TextColumn::make('author.name')
                    ->searchable()
                    ->sortable()
                    ->label('Szerző'),
                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->label('Kategória'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'draft',
                        'success' => 'published',
                        'warning' => 'scheduled',
                        'danger' => 'archived',
                    ])
                    ->label('Státusz'),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Publikálva'),
                Tables\Columns\TextColumn::make('view_count')
                    ->numeric()
                    ->sortable()
                    ->label('Megtekintések'),
                Tables\Columns\ImageColumn::make('featured_image')
                    ->label('Kiemelt kép')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Piszkozat',
                        'published' => 'Publikált',
                        'scheduled' => 'Ütemezett',
                        'archived' => 'Archivált',
                    ])
                    ->label('Státusz'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
