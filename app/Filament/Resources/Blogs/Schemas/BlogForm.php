<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\HtmlString;
use App\Models\BlogCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Illuminate\Support\Str;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(fn() => new HtmlString('Title<sup style="color:red">*</sup>'))
                    ->placeholder('Enter title')
                    //->required()
                    ->rules([
                        'required'
                    ])
                    ->validationMessages([
                        'required' => 'Title can not be blank!',
                    ]),
               TextInput::make('slug')
                ->placeholder('Enter blog slug')
                ->label(fn() => new HtmlString(
                    'Slug<sup style="color:red">*</sup>'
                ))
                ->rules([
                        'required'
                    ])
                // ->required()
                ->unique(ignoreRecord: true)
                ->disabled(fn(string $operation): bool => $operation === 'edit')
                ->formatStateUsing(fn ($state) => $state ? Str::slug($state) : $state)
                ->dehydrateStateUsing(fn ($state) => $state ? Str::slug($state) : $state)
                ->validationMessages([
                    'required' => 'Slug can not be blank!',
                ]),
                

                Select::make('category')
                    ->label(fn() => new HtmlString(
                        'Category <sup style="color:red">*</sup>'
                    ))
                    ->placeholder('Select category')
                    ->options(
                        BlogCategory::query()
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => 'Please select a category!',
                    ]),
                TagsInput::make('tags')
                    ->label('Tags')
                    ->placeholder('Enter tag and press Enter')
                    ->separator(',')
                    ->reorderable()
                    ->nestedRecursiveRules([
                        'string',
                        'max:100',
                    ]),
                // ->columnSpanFull(),

                Textarea::make('excerpt')
                    ->label('Excerpt')
                    ->placeholder('Enter short blog excerpt')
                    ->rows(3)
                    ->maxLength(100),
                // ->columnSpanFull(),
                Section::make('Feature Image')
                    ->schema([

                        FileUpload::make('feature_image')
                            ->label('Feature Image')
                            ->image()
                            ->imageEditor()
                            ->directory('')
                            ->disk('blog_images')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes([
                                'image/jpeg',
                                'image/png',
                                'image/webp',
                                'image/jpg',
                            ])
                            ->columnSpanFull(),

                        TextInput::make('feature_image_alt')
                            ->label('Feature Image Alt')
                            ->placeholder('Enter image alt text')
                            ->maxLength(255)
                            ->columnSpanFull(),

                    ]),
                Section::make('Blog Content')
                    ->schema([
                        RichEditor::make('content')
                            ->label('Content')
                            ->placeholder('Write your blog content...')
                            ->extraAttributes([
                                'style' => 'min-height: 200px;',
                            ])
                            
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                Section::make('SEO Information')
                    ->schema([

                        TextInput::make('meta_title')
                            ->label(fn() => new HtmlString(
                                'Meta Title <sup style="color:red">*</sup>'
                            ))
                            ->rules([
                                'required'
                            ])
                            ->placeholder('Enter meta title')
                            ->maxLength(255)
                            ->validationMessages([
                                'required' => 'Meta title can not be blank!',
                            ])
                            ->columnSpanFull(),

                        TextInput::make('keywords')
                            ->label(fn() => new HtmlString(
                                'Keywords <sup style="color:red">*</sup>'
                            ))
                            ->rules([
                                'required'
                            ])
                            ->placeholder('Laravel, PHP, Filament, MySQL')
                            ->maxLength(1000)
                            ->validationMessages([
                                'required' => 'Keywords can not be blank!',
                            ])

                            ->columnSpanFull(),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->placeholder('Enter meta description')
                            ->rows(5)
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Textarea::make('schema')
                            ->label('Schema')
                            ->placeholder('Enter schema')
                            ->rows(10)
                            ->columnSpanFull(),

                    ])
                    ->columns(2),

                Repeater::make('faqs')
                    ->label('FAQs')
                    ->relationship('faq')
                    ->schema([
                        TextInput::make('question')
                            ->label('Question')
                            ->placeholder('Enter FAQ question')
                            // ->required()
                            ->maxLength(500)
                            ->columnSpanFull(),

                        Textarea::make('answer')
                            ->label('Answer')
                            ->placeholder('Enter FAQ answer')
                            // ->required()
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->defaultItems(1)
                    ->addActionLabel('Add FAQ')
                    ->reorderable()
                    ->collapsible()
                    // ->cloneable()
                    ->itemLabel(
                        fn(array $state): string =>
                        $state['question'] ?? 'New FAQ'
                    )
                    ->columnSpanFull(),
                Toggle::make('status')
                    ->label('Status')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->default(true)
                    ->formatStateUsing(fn($state) => (bool) $state)
                    ->dehydrateStateUsing(fn($state) => $state ? 1 : 0)
                    ->columnSpanFull(),

            ]);
    }
}
