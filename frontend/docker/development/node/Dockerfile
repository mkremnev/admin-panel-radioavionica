FROM node:13-alpine

COPY ../../public/package.json /app

RUN npm install

CMD [ "npm", "run", "build" ]

WORKDIR /app