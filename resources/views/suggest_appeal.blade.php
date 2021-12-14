<script>
    if (confirm('Хотели бы вы отправить обращение?')) {
        document.location.href = "{{ route('appeal') }}"
    }
</script>
