// Check if query params 'alert' is present and show alert, then remove it from the URL
export const setupAlert = () => {
  const urlParams = new URLSearchParams(window.location.search);
  const _alert = urlParams.get("alert") as string;
  if (_alert) {
    alert(_alert);
    history.replaceState(null, "", window.location.pathname);
  }
};
