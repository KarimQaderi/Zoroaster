<button data-view="{{ $view }}" uk-icon="delete" class="uk-icon @if (array_key_exists('deleted_at',$data->attributesToArray())) softDeleting @else ForceDeleting @endif delete-one-resource action--delete"
        resourceId="{{
$data->{$model->getKeyName
()} }}"></button>

@if($view == 'Detail')


@endif