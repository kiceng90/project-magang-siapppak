class FormService {
  /**
   * Convert object to form data
   * @param {object} data Data to convert to FormData
   * @param {string[]} deepNested Array of key to set as deep nested
   * @returns {FormData}
   */
  static toFormData(data, deepNested = []) {
    const formData = new FormData();

    function deepNestedToArrayNested(initialKey, obj) {
      for (const [key, value] of Object.entries(obj)) {
        // eslint-disable-next-line no-use-before-define
        appendData(`${initialKey}[${key}]`, value, true);
      }
    }

    function appendData(key, value, deep = false) {
      let isAppend = true;

      if (Array.isArray(value)) {
        const checkKey = key.replace(/\[\d+\]/g, '[]'); // replaces items[0][title] to items[][title]
        if (deep || deepNested.includes(checkKey)) {
          deepNestedToArrayNested(key, value);
          return;
        }
        value.forEach((val) => {
          appendData(`${key}[]`, val);
        });
        isAppend = false;
      } else if (value === null || typeof value === 'undefined') {
        value = '';
      } else if (value instanceof Date) {
        value = value.toISOString();
      } else if (typeof value === 'object' && !(value instanceof Blob)) {
        Object.keys(value).forEach((keyObj) => {
            isAppend = false;
            appendData(`${key}[${keyObj}]`, value[keyObj]);
        });
        value = "";
      }

      if (isAppend) {
        formData.append(key, value);
      }
    }

    for (let [key, value] of Object.entries(data)) {
      appendData(key, value);
    }
    return formData;
  }
}

export default FormService;
