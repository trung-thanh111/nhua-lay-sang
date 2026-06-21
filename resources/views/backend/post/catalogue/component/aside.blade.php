<div class="ibox w">
    <div class="ibox-title">
        <h5>{{ __('messages.parent') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <span class="text-danger notice" >*{{ __('messages.parentNotice') }}</span>
                    <select name="parent_id" class="form-control setupSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option {{ 
                            $key == old('parent_id', (isset($postCatalogue->parent_id)) ? $postCatalogue->parent_id : '') ? 'selected' : '' 
                            }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <h5>Cấu hình hiển thị</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">Sắp xếp bài viết</label>
                    <select name="post_order" class="form-control setupSelect2" id="">
                        <option {{ old('post_order', $postCatalogue->post_order ?? 'latest') == 'latest' ? 'selected' : '' }} value="latest">Mới nhất</option>
                        <option {{ old('post_order', $postCatalogue->post_order ?? '') == 'order' ? 'selected' : '' }} value="order">Theo số thứ tự (Order)</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.dashboard.component.publish', ['model' => ($postCatalogue) ?? null, 'hideImage' => false])