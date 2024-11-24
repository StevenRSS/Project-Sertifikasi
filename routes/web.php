<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;


Route::get('/', [DashboardController::class, 'showData'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'showAllData'])->name('dashboard.data');
Route::get('/borrow/add', [DashboardController::class, 'addBorrow'])->name('borrow.add');
Route::post('/borrow/store', [DashboardController::class, 'store'])->name('borrow.store');
Route::get('/borrow/edit/{id}', [DashboardController::class, 'editBorrow'])->name('borrow.edit');
Route::put('/borrow/update/{id}', [DashboardController::class, 'update'])->name('borrow.update');
Route::delete('/borrow/delete/{id}', [DashboardController::class, 'delete'])->name('borrow.delete');

Route::get('/book', [BookController::class, 'index'])->name('book');
Route::get('/book/data', [BookController::class, 'showAllData'])->name('book.data');
Route::get('/book/add', [BookController::class, 'addBook'])->name('book.add');
Route::post('/books/store', [BookController::class, 'store'])->name('book.store');
Route::get('/books/edit/{id}', [BookController::class, 'editBook'])->name('book.edit');
Route::put('/books/update/{id}', [BookController::class, 'update'])->name('book.update');
Route::delete('/books/delete/{id}', [BookController::class, 'delete'])->name('book.delete');

Route::get('/category', [CategoryController::class, 'index'])->name('category');
Route::get('/category/data', [CategoryController::class, 'showAllData'])->name('category.data');
Route::get('/category/add', [CategoryController::class, 'addCategory'])->name('category.add');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{id}', [CategoryController::class, 'editCategory'])->name('category.edit');
Route::put('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
Route::delete('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

Route::get('/member', [MemberController::class, 'index'])->name('member');
Route::get('/member/data', [MemberController::class, 'showAllData'])->name('member.data');
Route::get('/member/add', [MemberController::class, 'addMember'])->name('member.add');
Route::post('/member/store', [MemberController::class, 'store'])->name('member.store');
Route::get('/member/edit/{id}', [MemberController::class, 'editMember'])->name('member.edit');
Route::put('/member/update/{id}', [MemberController::class, 'update'])->name('member.update');
Route::delete('/member/delete/{id}', [MemberController::class, 'delete'])->name('member.delete');
