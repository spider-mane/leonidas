export default props => {
  const data = () => props.data;

  return (
    <video ref={props.ref} controls controlslist="nodownload">
      <source src={data().src} type={data().mime} />
    </video>
  );
};
