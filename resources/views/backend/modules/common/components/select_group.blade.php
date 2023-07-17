<option value="" disabled selected>Select group</option>
@foreach( $groups as $key => $group )
<option value="{{ $group->id }}" @if( $key == 0 ) selected @endif >{{ $group->name }}</option>
@endforeach