@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-cog me-2"></i>Pengaturan Website
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <ul class="nav nav-tabs mb-4" id="settingTabs" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" data-bs-toggle="tab" data-bs-target="#general">
                            <i class="fas fa-info-circle me-1"></i>Umum
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#contact">
                            <i class="fas fa-address-card me-1"></i>Kontak
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" data-bs-toggle="tab" data-bs-target="#social">
                            <i class="fas fa-share-alt me-1"></i>Media Sosial
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- General Tab -->
                    <div class="tab-pane fade show active" id="general">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Website</label>
                                <input type="text" name="site_name" class="form-control"
                                    value="{{ $settings['site_name'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tagline</label>
                                <input type="text" name="site_tagline" class="form-control"
                                    value="{{ $settings['site_tagline'] ?? '' }}">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi Website</label>
                                <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Kelurahan</label>
                                <input type="text" name="kelurahan_name" class="form-control"
                                    value="{{ $settings['kelurahan_name'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan_name" class="form-control"
                                    value="{{ $settings['kecamatan_name'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kota</label>
                                <input type="text" name="city_name" class="form-control"
                                    value="{{ $settings['city_name'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" name="province_name" class="form-control"
                                    value="{{ $settings['province_name'] ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Tab -->
                    <div class="tab-pane fade" id="contact">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" rows="2">{{ $settings['address'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="phone" class="form-control"
                                    value="{{ $settings['phone'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fax</label>
                                <input type="text" name="fax" class="form-control"
                                    value="{{ $settings['fax'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ $settings['email'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control"
                                    value="{{ $settings['whatsapp'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitude</label>
                                <input type="text" name="latitude" class="form-control"
                                    value="{{ $settings['latitude'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitude</label>
                                <input type="text" name="longitude" class="form-control"
                                    value="{{ $settings['longitude'] ?? '' }}">
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Tab -->
                    <div class="tab-pane fade" id="social">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i
                                        class="fab fa-facebook text-primary me-1"></i>Facebook</label>
                                <input type="url" name="facebook" class="form-control"
                                    value="{{ $settings['facebook'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i
                                        class="fab fa-instagram text-danger me-1"></i>Instagram</label>
                                <input type="url" name="instagram" class="form-control"
                                    value="{{ $settings['instagram'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fab fa-twitter text-info me-1"></i>Twitter</label>
                                <input type="url" name="twitter" class="form-control"
                                    value="{{ $settings['twitter'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fab fa-youtube text-danger me-1"></i>YouTube</label>
                                <input type="url" name="youtube" class="form-control"
                                    value="{{ $settings['youtube'] ?? '' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fab fa-tiktok me-1"></i>TikTok</label>
                                <input type="url" name="tiktok" class="form-control"
                                    value="{{ $settings['tiktok'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
