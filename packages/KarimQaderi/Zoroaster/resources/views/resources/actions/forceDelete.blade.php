<button data-view="{{ $view }}" uk-tooltip="title: حذف کامل; pos: bottom" class="uk-icon bg-hover ForceDeleting action--delete" uk-icon="force-delete" @if($view == 'Detail') resourceId="{{ $data->{$model->getKeyName()}
}}" @endif
></button>
