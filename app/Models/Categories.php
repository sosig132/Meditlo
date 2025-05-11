<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['name', 'user_id'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function materials() {
        return $this->hasMany(Materials::class);
    }
    public static function addCategory($name, $userId) {
        return self::create([
            'name' => $name,
            'user_id' => $userId,
        ]);
    }
    public static function getAllCategories($userId) {
        return self::where('user_id', $userId)->get();
    }
    public static function getCategoryById($id) {
        return self::find($id);
    }
    public static function updateCategory($id, $name) {
        $category = self::find($id);
        if ($category) {
            $category->name = $name;
            $category->save();
            return $category;
        }
        return null;
    }
    public static function deleteCategory($id) {
        $category = self::find($id);
        if ($category) {
            $category->delete();
            return true;
        }
        return false;
    }
    public static function getCategoryMaterials($categoryId) {
        return self::find($categoryId)->materials;
    }
    public static function getCategoryName($categoryId) {
        return self::find($categoryId)->name;
    }
    public static function getCategoryId($categoryName) {
        return self::where('name', $categoryName)->first()->id;
    }
    

}
