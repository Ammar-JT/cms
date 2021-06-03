<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = Category::create([
            'name' => 'News'
        ]);
        $category2 = Category::create([
            'name' => 'Marketing'
        ]);
        $category3 = Category::create([
            'name' => 'Partnership'
        ]);

        $post1 = Post::create([
            'title' => 'We relocated our office to a new designed garage',
            'description' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'content' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'category_id' => $category1->id,
            'image' => 'images/posts/1.jpg'

        ]);

        $post2 = Post::create([
            'title' => 'Top 5 Brilliant content marketing strategis',
            'description' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'content' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'category_id' => $category2->id,
            'image' => 'images/posts/2.jpg'


        ]);

        $post3 = Post::create([
            'title' => 'Best practise for mininmalist design with example',
            'description' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'content' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'category_id' => $category3->id,
            'image' => 'images/posts/3.jpg'


        ]);

        $post4 = Post::create([
            'title' => 'Congratulate and thank to Maryam for joining our team',
            'description' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'content' => "Lorem Ipsum has been the industry's standard dummy text ever since the 1500s",
            'category_id' => $category2->id,
            'image' => 'images/posts/4.jpg'


        ]);


        $tag1 = Tag::create([
            'name' => 'job'
        ]);

        $tag2 = Tag::create([
            'name' => 'customers'
        ]);

        $tag3 = Tag::create([
            'name' => 'record'
        ]);

        //attach posts with tags, cuz they have n to n relationship: 
        $post1->tags()->attach([$tag1->id, $tag2->id]);
        $post2->tags()->attach([$tag2->id, $tag3->id]);
        $post3->tags()->attach([$tag1->id, $tag3->id]);
    }
}
