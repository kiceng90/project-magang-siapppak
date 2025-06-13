import { unref } from "vue";

function unwrapNormalizedValidator(validator) {
  return validator.$validator || validator;
}

function unwrapValidatorResponse(result) {
  if (typeof result === "object") return result.$valid;
  return result;
}

export default function (validators) {
  return {
    $validator: (list) => {
      return unref(list).reduce(
        (previous, object) => {
          const result = Object.entries(object).reduce(
            (all, [key, value]) => {
              const innerValidators = validators[key];
              const result = Object.entries(innerValidators).reduce(
                (all, [propertyName, currentValidator]) => {
                  const validatorFunction = unwrapNormalizedValidator(
                    currentValidator
                  );
                  const result = validatorFunction(value);
                  const $valid = all.$valid && unwrapValidatorResponse(result);
                  let message = currentValidator.$message || "";
                  let params = currentValidator.$params || {};
                  if (typeof message === "function") {
                    message = message({
                      $pending: false,
                      $invalid: !$valid,
                      $params: params,
                      $model: value,
                      $response: result
                    });
                  }
                  return {
                    $valid,
                    $data: {
                      ...all.$data,
                      [propertyName]: result
                    },
                    $message: {
                      ...all.$message,
                      ...(!$valid ? { [propertyName]: message } : {})
                    }
                  };
                },
                { $valid: true, $data: {}, $message: {} }
              );
              return {
                $valid: all.$valid && result.$valid,
                $data: { ...all.$data, [key]: result.$data },
                $message: { ...all.$message, [key]: result.$message }
              };
            },
            { $valid: true, $data: {}, $message: {} }
          );
          return {
            $valid: previous.$valid && result.$valid,
            $data: previous.$data.concat(result.$data),
            $message: previous.$message.concat(result.$message)
          };
        },
        { $valid: true, $data: [], $message: [] }
      );
    },
    $message: ({ $response }) => ($response ? $response.$message : [])
  };
}
