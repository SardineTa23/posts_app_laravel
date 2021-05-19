<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;
    protected $int = 0;
    protected $tags = [
        '',
        'テクノロジー',
        'モバイル',
        'アプリ',
        'ファッション',
        'グルメ',
        'スポーツ',
        'エンタメ',
        'ビューティー',
        'ライフスタイル',
        'ビジネス'
    ];
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->int ++;
        return [
            //
            'name'  => $this->tags[$this->int]
        ];
    }
}
