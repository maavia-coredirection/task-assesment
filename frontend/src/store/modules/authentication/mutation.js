export default {
  storeAuthTokenMutation(_, data) {
    localStorage.setItem('token', "Bearer " + data);
  },
  removeAuthTokenMutation() {
    localStorage.removeItem('token');
  }
};
