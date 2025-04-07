@extends('layouts.admin')

@section('styles')
    <!-- Trumbowyg CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.27.3/dist/ui/trumbowyg.min.css">
@endsection

@section('admin_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tartalom szerkesztése</h1>
        <a href="{{ route('admin.content.list') }}" class="btn btn-secondary">Vissza a listához</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.content.update', $content->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="key" class="form-label">Egyedi azonosító (key)</label>
                    <input type="text" class="form-control" id="key" value="{{ $content->key }}" disabled readonly>
                    <small class="text-muted">Az egyedi azonosító nem módosítható a létrehozás után.</small>
                </div>

                <ul class="nav nav-tabs mb-3" id="contentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="hungarian-tab" data-bs-toggle="tab" data-bs-target="#hungarian" type="button" role="tab" aria-controls="hungarian" aria-selected="true">Magyar</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button" role="tab" aria-controls="english" aria-selected="false">Angol</button>
                    </li>
                </ul>

                <div class="tab-content" id="contentTabsContent">
                    <div class="tab-pane fade show active" id="hungarian" role="tabpanel" aria-labelledby="hungarian-tab">
                        <div class="mb-3">
                            <label for="title" class="form-label">Cím (Magyar)</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $content->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Tartalom (Magyar)</label>
                            <textarea class="form-control editor @error('content') is-invalid @enderror" id="content" name="content" rows="15">{{ old('content', $content->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="tab-pane fade" id="english" role="tabpanel" aria-labelledby="english-tab">
                        <div class="mb-3">
                            <label for="title_english" class="form-label">Cím (Angol)</label>
                            <input type="text" class="form-control @error('title_english') is-invalid @enderror" id="title_english" name="title_english" value="{{ old('title_english', $content->title_english) }}">
                            @error('title_english')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content_english" class="form-label">Tartalom (Angol)</label>
                            <textarea class="form-control editor @error('content_english') is-invalid @enderror" id="content_english" name="content_english" rows="15">{{ old('content_english', $content->content_english) }}</textarea>
                            @error('content_english')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sorrend</label>
                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order" value="{{ old('sort_order', $content->sort_order) }}" min="0">
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $content->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktív</label>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-stanford">Mentés</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Trumbowyg JS -->
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.27.3/dist/trumbowyg.min.js"></script>
    <!-- Colors plugin JS -->
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.27.3/dist/plugins/colors/trumbowyg.colors.min.js"></script>
    


    <script>
        $(document).ready(function() {
            $('.editor').trumbowyg({
                btns: [
                    ['viewHTML'],
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['insertImage'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen']
                    ['foreColor', 'backColor'],
                    ['btnPrimary', 'btnSuccess'], // ezeket majd te hozod létre (lásd lent)
                ],

                plugins: {
                    colors: {
                        colorList: [
                            'ffffff', '000000', 'e74c3c', '3498db', '2ecc71', 'f1c40f'
                        ]
                    }
                }


            });
        });



        $.trumbowyg.plugins.btnPrimary = {
    init: function(trumbowyg) {
        trumbowyg.addBtnDef('btnPrimary', {
            fn: function() {
                const text = trumbowyg.getRangeText() || 'Gomb';
                trumbowyg.execCmd('insertHTML', '<a href="#" class="btn btn-primary">' + text + '</a>');
            },
            tag: 'button',
            title: 'Elsődleges gomb',
            text: '🔵'
        });
    }
};

$.trumbowyg.plugins.btnSuccess = {
    init: function(trumbowyg) {
        trumbowyg.addBtnDef('btnSuccess', {
            fn: function() {
                const text = trumbowyg.getRangeText() || 'Siker';
                trumbowyg.execCmd('insertHTML', '<a href="#" class="btn btn-success">' + text + '</a>');
            },
            tag: 'button',
            title: 'Siker gomb',
            text: '✅'
        });
    }
};



    </script>
@endsection
