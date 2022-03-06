import api from "./index";

const baseRegistrationPrefix = "/auth";

export const createUserAccount = (data) => {
  const url = `${baseRegistrationPrefix}/signup`;
  return api("post", url, data);
}

export const loginUser = (data) => {
  const url = `${baseRegistrationPrefix}/login`;
  return api("post", url, data);
}

export const forgotPassword = (data) => {
  const url = "/password/create";
  return api("post", url, data);
}
export const updatePassword = (data) => {
  const url = "/password/reset";
  return api("post", url, data);
}
