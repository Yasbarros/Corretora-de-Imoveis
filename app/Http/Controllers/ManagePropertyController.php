<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Property;
use App\Models\Address;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ManagePropertyController extends Controller
{
    public function indexAdmin()
    {
        return Inertia::render('AdminProperties', [
            'properties' => Property::all()->map(function($property) {
                $imagePaths = explode(',', $property->images);
                $imagePaths = array_map(function ($image) {
                    return Storage::url($image);
                }, $imagePaths);

                $address = Address::find($property->address_id);
    
                return [
                    'id' => $property->id,
                    'title' => $property->title,
                    'price' => $property->price,
                    'code' => $property->code,
                    'description' => $property->description,
                    'category' => $property->category,
                    'isForRent' => $property->isForRent,
                    'status' => $property->status,
                    'bedrooms' => $property->bedrooms,
                    'bathrooms' => $property->bathrooms,
                    'images' => $imagePaths,
                    'address' => $address,
                ];
            }),
        ]);
    }

    public function index() {
        $properties = Property::paginate(8);

                return Inertia::render('Home', [
            'properties' => $properties->map(function($property) {
                $imagePaths = explode(',', $property->images);
                $imagePaths = array_map(function ($image) {
                    return Storage::url($image);
                }, $imagePaths);
    
                $address = Address::find($property->address_id);
    
                return [
                    'id' => $property->id,
                    'title' => $property->title,
                    'price' => $property->price,
                    'code' => $property->code,
                    'description' => $property->description,
                    'category' => $property->category,
                    'isForRent' => $property->isForRent,
                    'status' => $property->status,
                    'bedrooms' => $property->bedrooms,
                    'bathrooms' => $property->bathrooms,
                    'images' => $imagePaths,
                    'address' => $address,
                ];
            }),
            'properties_pagination' => $properties,
        ]);
    }

    public function show($id) {
        // dd($id);
        $property = Property::find($id);

        // dd($property);

        $imagePaths = explode(',', $property->images);
        $imagePaths = array_map(function ($image) {
            return Storage::url($image);
        }, $imagePaths);

        $address = Address::find($property->address_id);

        $propertyData = [
            'id' => $property->id,
            'title' => $property->title,
            'price' => $property->price,
            'code' => $property->code,
            'description' => $property->description,
            'category' => $property->category,
            'isForRent' => $property->isForRent,
            'status' => $property->status,
            'bedrooms' => $property->bedrooms,
            'bathrooms' => $property->bathrooms,
            'images' => $imagePaths,
            'address' => $address,
        ];

        return Inertia::render('Property', [
            'property' => $propertyData,
        ]);
    }

    public function showAdmin($id) {
        $property = Property::find($id);

        $imagePaths = explode(',', $property->images);
        $imagePaths = array_map(function ($image) {
            return Storage::url($image);
        }, $imagePaths);

        $address = Address::find($property->address_id);

        $propertyData = [
            'id' => $property->id,
            'title' => $property->title,
            'price' => $property->price,
            'code' => $property->code,
            'description' => $property->description,
            'category' => $property->category,
            'isForRent' => $property->isForRent,
            'status' => $property->status,
            'bedrooms' => $property->bedrooms,
            'bathrooms' => $property->bathrooms,
            'images' => $imagePaths,
            'address' => $address,
        ];

        return Inertia::render('AdminProperty', [
            'property' => $propertyData,
        ]);

    }

    public function register()
    {
        return Inertia::render('RegisterProperty'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'cep' => 'required|string',
            'district' => 'required|string',
            'street' => 'required|string',
            'number' => 'required|numeric',
            'complement' => 'required|string',
            'price' => 'required|numeric',
            'code' => 'required|numeric',
            'description' => 'required|string',
            'category' => 'required|string',
            'isForRent' => 'required|string',
            'status' => 'required|string',
            'bedrooms' => 'required|numeric',
            'bathrooms' => 'required|numeric',
            'images.*' => 'required|file|mimes:jpeg,png,jpg'
        ]);

        $manager = ImageManager::gd();

        $files = $request->file('images');

        $imagesPaths = [];

        foreach($files as $file) {
            $originalFilename = $file->getClientOriginalName();
            $filename = time() . '-' . $originalFilename;

            $image = $manager->read($file);
            $image->scaleDown(height: 500);

            $image->save(base_path('storage/app/public/' . $filename));
            $path = 'public/' . $filename;

            $imagesPaths[] = $path;
        }

        $images = implode(',', $imagesPaths);

        $address = Address::create([
            'cep' => $request->cep,
            'district' => $request->district,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
        ]);

        $isForRent = $request->isForRent == 'Aluguel' ? true : false;
        $status = $request->status == 'Ativo' ? true : false;
        $category = $request->category == 'Casa' ? true : false;

        Property::create([
            'title' => $request->title,
            'address_id' => $address->id,
            'price' => $request->price,
            'code' => $request->code,
            'description' => $request->description,
            'category' => $category,
            'isForRent' => $isForRent,
            'status' => $status,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'images' => $images
        ]);

        return Redirect::route('manageProperty.index');
    }

    public function edit($id) {
        $property = Property::find($id);

        $imagePaths = explode(',', $property->images);
        $imagePaths = array_map(function ($image) {
            return Storage::url($image);
        }, $imagePaths);

        $address = Address::find($property->address_id);

        return Inertia::render("EditProperty", [
            'property' => [
                'id' => $property->id,
                'title' => $property->title,
                'price' => $property->price,
                'code' => $property->code,
                'description' => $property->description,
                'category' => $property->category,
                'isForRent' => $property->isForRent,
                'status' => $property->status,
                'bedrooms' => $property->bedrooms,
                'bathrooms' => $property->bathrooms,
                'images' => $imagePaths,
                'address' => $address,
            ]
        ]);
    }

    public function update(Request $request) {
        // dd($request->all());

        // $request->validate([
        //     'title' => 'required|string',
        //     'cep' => 'required|string',
        //     'district' => 'required|string',
        //     'street' => 'required|string',
        //     'number' => 'required|numeric',
        //     'complement' => 'required|string',
        //     'price' => 'required|numeric',
        //     'code' => 'required|numeric',
        //     'description' => 'required|string',
        //     'category' => 'required|string',
        //     'isForRent' => 'required|string',
        //     'status' => 'required|string',
        //     'bedrooms' => 'required|numeric',
        //     'bathrooms' => 'required|numeric',
        //     'newImages.*' => 'file|mimes:jpeg,png,jpg'
        // ]);

        $property = Property::find($request->code);

        $property->title = $request->title;
        $property->price = $request->price;
        $property->code = $request->code;
        $property->description = $request->description;
        $property->category = $request->category == 'Casa' ? true : false;
        $property->isForRent = $request->isForRent == 'Aluguel' ? true : false;
        $property->status = $request->status == 'Ativo' ? true : false;
        $property->bedrooms = $request->bedrooms;
        $property->bathrooms = $request->bathrooms;

        if ($request->has('removedImages')) {
            $removedImages = $request->removedImages;

            foreach ($removedImages as $removedImage) {

                $pathWithoutStorage = str_replace('/storage/', '', $removedImage);

                Storage::delete("public/" . $pathWithoutStorage);
            }

        }

        if($request->has('images')) {
            $images = $request->images;

            $imagesPaths = [];
            
            foreach($images as $image) {
                $pathWithoutStorage = str_replace('/storage/', '', $image);

                $imagesPaths[] = "public/" . $pathWithoutStorage;
            }

            $property->images = implode(',', $imagesPaths);
        }

        if ($request->hasFile('newImages')) {
            $manager = ImageManager::gd();
        
            $files = $request->file('newImages');
        
            $newImagesPaths = [];
        
            foreach($files as $file) {
                $originalFilename = $file->getClientOriginalName();
                $filename = time() . '-' . $originalFilename;
        
                $image = $manager->read($file);
                $image->scaleDown(height: 500);
        
                $image->save(base_path('storage/app/public/' . $filename));
                $path = 'public/' . $filename;
        
                $newImagesPaths[] = $path;
            }

            $property->images .= ',' . implode(',', $newImagesPaths);
        }

        $property->save();

        $address = Address::find($property->address_id);
        $address->cep = $request->cep;
        $address->district = $request->district;
        $address->street = $request->street;
        $address->number = $request->number;
        $address->complement = $request->complement;
        $address->save();

        return Redirect::route('manageProperty.show', $property);
    }

    public function destroy($id)
    {
        $property = Property::find($id);
        $property->delete();

        return Redirect::route('manageProperty.index');
    }

    public function search(){
        $search = request('q');

        if($search){
            $properties = Property::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
        }

        return Inertia::render('Search',['properties'=>$properties, 'search' =>$search]);

    }
}
