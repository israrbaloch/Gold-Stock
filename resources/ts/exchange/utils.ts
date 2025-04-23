export const addCommas = (value: number, fractions = 2) => {
  return new Intl.NumberFormat("en-US", {
    style: "decimal",
    minimumFractionDigits: 2,
    maximumFractionDigits: fractions,
  }).format(value);
};

export const removeFormat = (value: string): number => {
  return parseFloat(value.replace(/,/g, "").replace("$", ""));
};

export const setFraction = (value: number, fractions = 2): number => {
  const factor = Math.pow(10, fractions);
  return parseFloat((Math.floor(value * factor) / factor).toFixed(fractions));
};
