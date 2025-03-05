export default props => {
  const data = () => props.data;
  const src = () => data().sizes.large.url;

  return (
    <picture class="" ref={props.ref}>
      <img src={src()} alt={data().alt} loading="lazy" />
    </picture>
  );
};
