<form method="post" action="{{ path('account_delete', {'id': app.user.id}) }}"
      onsubmit="return confirm('Are you sure that you want to delete this account?')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{ csrf_token('delete' ~ app.user.id) }}">
    <div class="text-right">
    <button class="btn btn-danger mt-2">Delete account</button></div>
</form>