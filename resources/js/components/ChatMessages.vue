<template>
    <ul class="chat" style="height: 485px; overflow: auto;">
      <li class="left clearfix" v-for="(message, index) in messages" :key="message.id">
        <div class="clearfix">
          <div class="header">
            <strong>
              {{ message.user.name }}
            </strong>
          </div>
          <p class="chatlogs">
            {{ message.message }} - {{ format_date(message?.time || message.created_at) }}
          </p>
        </div>
      </li>
    </ul>
  </template>
  <script>
import moment from 'moment';

  export default {
    props: ["messages"],
    methods: {
        format_date(val) {
          const time = moment(String(val)).format('hh:mm MM/DD/YYYY')
          return time;
        }
    }
  };
  </script>