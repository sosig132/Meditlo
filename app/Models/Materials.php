<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    use HasFactory;
    // public function up(): void
    // {
    //     Schema::create('materials', function (Blueprint $table) {
    //         $table->id();
    //         $table->unsignedBigInteger('user_id');
    //         $table->unsignedBigInteger('category_id');
    //         $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    //         $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
    //         $table->string('name');
    //         $table->string('description');
    //         $table->string('file_uri');
    //         $table->string('file_type');
    //         $table->string('file_size');
    //         $table->timestamps();
    //     });
    // }
    protected $table = 'materials';
    protected $fillable = ['user_id', 'category_id', 'name', 'description', 'file_uri', 'file_type', 'file_size'];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function category() {
        return $this->belongsTo(Categories::class);
    }
    public static function addMaterial($data) {
        return self::create($data);
    }
    public static function getAllMaterials($userId) {
        return self::where('user_id', $userId)->get();
    }
    public static function getMaterialById($id) {
        return self::find($id);
    }
    public static function updateMaterial($id, $data) {
        $material = self::find($id);
        if ($material) {
            $material->update($data);
            return $material;
        }
        return null;
    }
    public static function deleteMaterial($id) {
        $material = self::find($id);
        if ($material) {
            $material->delete();
            return true;
        }
        return false;
    }
    public static function getMaterialsByCategory($categoryId, $userId) {
        return self::where('category_id', $categoryId)->where('user_id', $userId)->get();
    }

    public static function getMaterialName($materialId) {
        return self::find($materialId)->name;
    }
}
