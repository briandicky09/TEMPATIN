<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateKosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $kos = $this->route('kos');

        if ($kos instanceof \App\Models\Kos) {
            return $this->user() !== null && $this->user()->can('update', $kos);
        }

        if (is_string($kos)) {
            $kosModel = \App\Models\Kos::where('slug', $kos)->first();
            return $this->user() !== null && $kosModel !== null && $this->user()->can('update', $kosModel);
        }

        $slug = $this->route('slug');
        if (is_string($slug)) {
            $kosModel = \App\Models\Kos::where('slug', $slug)->first();
            return $this->user() !== null && $kosModel !== null && $this->user()->can('update', $kosModel);
        }

        return false;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('title') && !$this->filled('slug')) {
            $kos = $this->route('kos');
            $kosId = $kos instanceof \App\Models\Kos ? $kos->id : null;
            if (!$kosId && is_string($kos)) {
                $kosModel = \App\Models\Kos::where('slug', $kos)->first();
                $kosId = $kosModel?->id;
            }

            $baseSlug = Str::slug($this->input('title'));
            $slug = $baseSlug;
            $counter = 1;
            while (\App\Models\Kos::withTrashed()->where('slug', $slug)->where('id', '!=', $kosId)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }

            $this->merge([
                'slug' => $slug,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $kos = $this->route('kos');
        $ignoreId = $kos instanceof \App\Models\Kos ? $kos->id : null;

        $slugRule = Rule::unique('kos', 'slug');
        if ($ignoreId) {
            $slugRule->ignore($ignoreId);
        } else {
            $routeSlug = $this->route('slug');
            $ignoreSlug = is_object($routeSlug) ? ($routeSlug->slug ?? null) : $routeSlug;
            if (!empty($ignoreSlug)) {
                $slugRule->ignore($ignoreSlug, 'slug');
            }
        }

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', $slugRule],
            'type' => ['required', 'string', Rule::in(['Putra', 'Putri', 'Campur', 'Eksklusif'])],
            'city' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'address' => ['nullable', 'string', 'max:1000'],
            'area' => ['nullable', 'string', 'max:50'],
            'rooms' => ['nullable', 'string', 'max:50'],
            'bathrooms' => ['nullable', 'string', 'max:50'],
            'bedrooms' => ['nullable', 'string', 'max:50'],
            'garages' => ['nullable', 'string', 'max:50'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'description' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'status' => ['nullable', 'string', Rule::in(['active', 'inactive'])],
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['integer', 'distinct', 'exists:facilities,id'],
            'photos' => ['nullable', 'array'],
            'photos.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'delete_photos' => ['nullable', 'array'],
            'delete_photos.*' => ['integer', 'exists:kos_photos,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'nama kos',
            'type' => 'tipe kos',
            'city' => 'kota',
            'price' => 'harga sewa',
            'address' => 'alamat',
            'area' => 'luas kos',
            'rooms' => 'jumlah kamar',
            'bathrooms' => 'kamar mandi',
            'bedrooms' => 'tempat tidur',
            'garages' => 'fasilitas parkir',
            'latitude' => 'garis lintang (latitude)',
            'longitude' => 'garis bujur (longitude)',
            'description' => 'deskripsi kos',
            'thumbnail' => 'foto kos',
            'facilities' => 'fasilitas kos',
            'facilities.*' => 'fasilitas kos',
            'photos' => 'galeri foto kos',
            'photos.*' => 'foto galeri',
            'delete_photos' => 'foto yang akan dihapus',
            'delete_photos.*' => 'foto yang akan dihapus',
        ];
    }

    /**
     * Get custom error messages for validation failures.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.unique' => 'Nama kos atau slug ini sudah digunakan oleh properti lain.',
            'type.in' => 'Tipe kos yang dipilih harus salah satu dari: Putra, Putri, Campur, atau Eksklusif.',
            'facilities.array' => 'Fasilitas kos harus berupa daftar pilihan yang valid.',
            'facilities.*.exists' => 'Fasilitas yang dipilih tidak valid atau tidak ditemukan.',
            'facilities.*.distinct' => 'Fasilitas yang dipilih tidak boleh duplikat.',
            'photos.array' => 'Galeri foto harus berupa daftar file gambar.',
            'photos.*.image' => 'File galeri foto harus berupa gambar.',
            'photos.*.mimes' => 'Format foto galeri yang diperbolehkan hanya: jpeg, jpg, png, webp.',
            'photos.*.max' => 'Ukuran file foto galeri maksimal 2MB per foto.',
            'delete_photos.array' => 'Daftar foto yang akan dihapus harus berupa array.',
            'delete_photos.*.exists' => 'Foto yang dipilih untuk dihapus tidak valid atau tidak ditemukan.',
        ];
    }
}
