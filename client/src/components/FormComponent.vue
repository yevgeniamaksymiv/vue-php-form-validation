<template>
  <div class="container">
    <div class="row">
      <form style="width: 100%" method="post" @submit.prevent="submitForm">
        <div class="form-group row">
          <label for="title" class="col-md-2 col-form-label">Заголовок</label>
          <div class="col-md-10 mb-3">
            <input type="text" class="form-control" id="title" name="title" v-model="title">
            <div class="invalid-feedback d-block">
              {{ this.errors ? this.errors[0] : '' }}
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="annotation" class="col-md-2 col-form-label">Аннотация</label>
          <div class="col-md-10 mb-3">
            <textarea name="annotation" id="annotation" class="form-control" cols="30" rows="10" v-model="annotation">
            </textarea>
            <div class="invalid-feedback d-block">
              {{ this.errors ? this.errors[1] : '' }}
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="content" class="col-md-2 col-form-label">Текст новости</label>
          <div class="col-md-10 mb-3">
            <textarea name="content" id="content" class="form-control" cols="30" rows="10" v-model="content">
            </textarea>
            <div class="invalid-feedback d-block">
              {{ this.errors ? this.errors[2] : '' }}
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="email" class="col-md-2 col-form-label">Email автора для связи</label>
          <div class="col-md-10 mb-3">
            <input type="email" class="form-control" id="email" name="email" v-model="email">
            <div class="invalid-feedback d-block">
              {{ this.errors ? this.errors[3] : '' }}
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="views" class="col-md-2 col-form-label">Кол-во просмотров</label>
          <div class="col-md-10 mb-3">
            <input type="text" class="form-control" id="views" name="views" v-model="views">
            <div class="invalid-feedback d-block">
              {{ this.errors ? this.errors[4] : '' }}
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="date" class="col-md-2 col-form-label">Дата публикации</label>
          <div class="col-md-10 mb-3">
            <input type="date" class="form-control" id="date" name="date" v-model="date">
            <div class="invalid-feedback d-block">
              {{ this.errors ? this.errors[5] : '' }}
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="is_publish" class="col-md-2 col-form-label">Публичная новость</label>
          <div class="col-md-10 mb-3">
            <input type="checkbox" class="form-control" id="is_publish" name="is_publish">
            <div class="invalid-feedback d-block"></div>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-2 col-form-label">Публиковать на главной</label>
          <div class="col-md-10 mb-3">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="publish_in_index" id="publish_in_index_yes"
                v-model="publish_in_index" value="yes" :checked="isValid">
              <label class="form-check-label" for="publish_in_index_yes">
                Да
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="publish_in_index" id="publish_in_index_no"
                v-model="publish_in_index" value="no">
              <label class="form-check-label" for="publish_in_index_no">
                Нет
              </label>
            </div>
            <div class="invalid-feedback d-block">
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label for="category" class="col-md-2 col-form-label">Публичная новость</label>
          <div class="col-md-10 mb-3">
            <select id="category" class="form-control" name="category" v-model="category">
              <option disabled selected>Выберете категорию из списка..</option>
              <option value="1">Спорт</option>
              <option value="2">Культура</option>
              <option value="3">Политика</option>
            </select>
            <div class="invalid-feedback d-block">
              {{ this.errors ? this.errors[6] : '' }}
            </div>
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-9">
            <button type="submit" class="btn btn-primary mb-3">Отправить</button>
          </div>
          <div class="col-md-3">
            <div class="alert alert-success mb-3" v-if="isValid">Форма валидна</div>
            <div class="alert alert-danger mb-3" v-else>Форма невалидна</div>
          </div>
        </div>
      </form>

    </div>
  </div>
</template>

<script>
// import axiosInstance from '../axios-config';
import axios from 'axios';

export default {
  name: 'FormComponent',
  data() {
    return {
      title: '',
      annotation: '',
      content: '',
      email: '',
      views: '',
      date: '',
      publish_in_index: '',
      category: '',
      isValid: true,
      errors: [],
    }
  },

  methods: {
    submitForm() {
      axios.post(
        'http://localhost:81/vue-php-form-validation/server/validation.php', this.formData
      )
        .then(response => {
          if (response.data['error']) {
            console.log('err', response.data['error'])
            this.errors = response.data['message'];
            this.isValid = false;
          } else {
            this.errors = [];
            this.isValid = true;
            this.title = '';
            this.annotation = '';
            this.content = '';
            this.email = '';
            this.views = '';
            this.date = '';
            this.category = '';
          }
        })
        .catch(err => console.log(err));

      // axiosInstance(this.formData)
      //   .then(response => {
      //     if (response.data['error']) {
      //       console.log('resp', response.data);
      //       this.errors = response.data['message'];
      //       this.isValid = false;
      //     } else {
      //       this.errors = [];
      //       this.isValid = true;
      //       this.title = '';
      //       this.annotation = '';
      //       this.content = '';
      //       this.email = '';
      //       this.views = '';
      //       this.date = '';
      //       this.category = '';
      //     }
      //   })
      //   .catch(err => console.log(err))
    }
  },

  computed: {
    formData() {
      return {
        title: this.title,
        annotation: this.annotation,
        content: this.content,
        email: this.email,
        views: this.views,
        date: this.date,
        publish_in_index: this.publish_in_index,
        category: this.category,
      }
    }
  }
}
</script>

<style scoped>

</style>
