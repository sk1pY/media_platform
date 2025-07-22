{{-- MODAL CLAIM WINDOW --}}
<div class="modal fade" id="complain_post" tabindex="-1" aria-labelledby="complainModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="complainModalLabel">Пожаловаться на пост</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Закрыть"></button>
            </div>
            <form action="{{ route('posts.claims.store',$post) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Выберите причину жалобы:</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason1"
                                   value="Оскорбления и грубое общение">
                            <label class="form-check-label" for="reason1">Оскорбления и грубое
                                общение</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason2"
                                   value="Преследование и травля">
                            <label class="form-check-label" for="reason2">Преследование и травля</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason3"
                                   value="Призывы и одобрение насилия">
                            <label class="form-check-label" for="reason3">Призывы и одобрение
                                насилия</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason4"
                                   value="Запрещенный к публикации контент">
                            <label class="form-check-label" for="reason4">Запрещенный к публикации
                                контент</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason5"
                                   value="Реклама и ссылки">
                            <label class="form-check-label" for="reason5">Реклама и ссылки</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason6"
                                   value="Другое">
                            <label class="form-check-label" for="reason6">Другое</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть
                    </button>
                    <button type="submit" class="btn btn-primary">Отправить</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END MODAL WINDOW --}}
