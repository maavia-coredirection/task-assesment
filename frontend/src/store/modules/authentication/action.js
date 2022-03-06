export default {
  storeAuthTokenAction(context, data) {
    context.commit('storeAuthTokenMutation', data);
  },
  removeAuthTokenAction(context) {
    context.commit('removeAuthTokenMutation');
  },
};
