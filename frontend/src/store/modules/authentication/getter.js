export default {
  getAuthToken(state) {
    return localStorage.getItem('token');
  }
};
